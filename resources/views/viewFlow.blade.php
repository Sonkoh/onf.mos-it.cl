<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Title</title>
    <link rel="stylesheet" href="../dist/jkanban.min.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Lato"
      rel="stylesheet"
    /><script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">

    <style>
      body {
        font-family: "Lato";
        margin: 0;
        padding: 0;
      }

      #myKanban {
        overflow-x: auto;
        padding: 20px 0;
      }

      .success {
        background: #00b961;
      }

      .info {
        background: #2a92bf;
      }

      .warning {
        background: #f4ce46;
      }

      .error {
        background: #fb7d44;
      }

      .custom-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 7px 15px;
        margin: 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
      }      
    </style>
  </head>
  <body>
    <div id="myKanban"></div>

    <script src="../dist/jkanban.js"></script>
    <script>
      var KanbanTest = new jKanban({
        element: "#myKanban",
        gutter: "10px",
        widthBoard: "450px",
        itemHandleOptions:{
          enabled: true,
        },
        click: function(el) {
          console.log("Trigger on all items click!");
        },
        context: function(el, e) {
          console.log("Trigger on all items right-click!");
        },
        dropEl: function(el, target, source, sibling){
          console.log(target.parentElement.getAttribute('data-id'));
          console.log(el, target, source, sibling)
        },
        buttonClick: function(el, boardId) {
          console.log(el);
          console.log(boardId);
          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        itemAddOptions: {
          enabled: true,
          content: '+ Add New Card',
          class: 'custom-button',
          footer: true
        },
        boards: [
          {
            id: "_todo",
            title: "To Do (Can drop item only in working)",
            class: "info,good",
            dragTo: ["_working"],
            item: [
              {
                id: "_test_delete",
                title: "Try drag this (Look the console)",
                drag: function(el, source) {
                  console.log("START DRAG: " + el.dataset.eid);
                },
                dragend: function(el) {
                  console.log("END DRAG: " + el.dataset.eid);
                },
                drop: function(el) {
                  console.log("DROPPED: " + el.dataset.eid);
                }
              },
              {
                title: "Try Click This!",
                click: function(el) {
                  alert("click");
                },
                context: function(el, e){
                  alert("right-click at (" + `${e.pageX}` + "," + `${e.pageX}` + ")")
                },
                class: ["peppe", "bello"]
              }
            ]
          },
          {
            id: "_working",
            title: "Working (Try drag me too)",
            class: "warning",
            item: [
              {
                title: "Do Something!"
              },
              {
                title: "Run?"
              }
            ]
          }
        ]
      });
    </script>
  </body>
</html>