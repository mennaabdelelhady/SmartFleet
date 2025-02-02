CREATE TABLE `cities`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `trips`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `start_city_id` BIGINT NOT NULL,
    `end_city_id` BIGINT NOT NULL,
    `bus_id` BIGINT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
);
CREATE TABLE `buses`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `trip_id` BIGINT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
);
CREATE TABLE `seats`(
    `bus_id` BIGINT NOT NULL,
    `seat_number` BIGINT NOT NULL,
    `id` BIGINT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    PRIMARY KEY(`id`)
);
ALTER TABLE
    `seats` ADD UNIQUE `seats_seat_number_unique`(`seat_number`);
CREATE TABLE `bookings`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT NOT NULL,
    `seat_id` BIGINT NOT NULL,
    `start_station_id` BIGINT NOT NULL,
    `end_station_id` BIGINT NOT NULL,
    `start_order` BIGINT NOT NULL,
    `end_order` BIGINT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
);
CREATE TABLE `users`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
);
CREATE TABLE `trip-stations`(
    `trip_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `station_id` BIGINT NOT NULL,
    `order` BIGINT NOT NULL
);
ALTER TABLE
    `seats` ADD CONSTRAINT `seats_bus_id_foreign` FOREIGN KEY(`bus_id`) REFERENCES `buses`(`id`);
ALTER TABLE
    `cities` ADD CONSTRAINT `cities_id_foreign` FOREIGN KEY(`id`) REFERENCES `trip-stations`(`trip_id`);
ALTER TABLE
    `trip-stations` ADD CONSTRAINT `trip_stations_trip_id_foreign` FOREIGN KEY(`trip_id`) REFERENCES `trips`(`id`);
ALTER TABLE
    `seats` ADD CONSTRAINT `seats_bus_id_foreign` FOREIGN KEY(`bus_id`) REFERENCES `bookings`(`id`);
ALTER TABLE
    `trips` ADD CONSTRAINT `trips_id_foreign` FOREIGN KEY(`id`) REFERENCES `trip-stations`(`trip_id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_id_foreign` FOREIGN KEY(`id`) REFERENCES `users`(`id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_id_foreign` FOREIGN KEY(`id`) REFERENCES `cities`(`id`);
ALTER TABLE
    `buses` ADD CONSTRAINT `buses_id_foreign` FOREIGN KEY(`id`) REFERENCES `trips`(`id`);
ALTER TABLE
    `trips` ADD CONSTRAINT `trips_id_foreign` FOREIGN KEY(`id`) REFERENCES `cities`(`id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_id_foreign` FOREIGN KEY(`id`) REFERENCES `trips`(`id`);