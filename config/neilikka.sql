
--
-- Rakenne taululle `resetpassword_tokens`
--

CREATE TABLE `resetpassword_tokens` (
  `users_id` int(9) NOT NULL,
  `token` varchar(255) NOT NULL,
  `voimassa` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `resetpassword_tokens`
  ADD PRIMARY KEY (`users_id`);

ALTER TABLE `resetpassword_tokens`
  ADD CONSTRAINT `resetpassword_tokens_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
