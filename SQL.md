# OperSys
#DB: onnet
#TABLES
## USERS
### id          | INT | AUTO | id++
### email       | STR |  --  | custom
### password    | STR |  --  | custom
### group       | STR | user | user|admin|mosit
### permissions | JSN | {..} | {..}
### expiration  | DTE |  --  | custom
### updated_at  | DTE |  --  | laravelsys
### created_at  | DTE |  --  | laravelsys

# ADD USER
INSERT INTO `users` (`id`, `email`, `password`, `group`, `permissions`, `expiration`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'joaquin.concha@mos-it.cl', '$2y$10$UqLn6asBep9MIVGRcXYXM.VukRrcS2LImMuajHePrnsGJj3CaDevK', 'user', '{}', '2023-08-10 00:00:00', 'nA6TcuBBawCjL4oF5tvdIWzYxb6Lq0AY7ZLBoS2JKzE6lNg4OoYWI46GC3yH', '2023-07-10 22:37:19', '2023-07-10 22:37:19');
