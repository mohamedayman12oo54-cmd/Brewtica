-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 12:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brewtica__db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `size`, `quantity`, `added_at`) VALUES
(102, 2, 'medium', 1, '2026-01-31 23:57:17'),
(102, 105, 'large', 2, '2026-01-31 23:57:33'),
(126, 2, 'medium', 1, '2026-02-01 10:56:29'),
(126, 52, 'large', 2, '2026-02-01 11:12:49'),
(126, 58, 'large', 3, '2026-02-01 11:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `loyalty_points` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` enum('pending','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(10, 30, 2, '2025-10-09 18:33:08'),
(23, 30, 45, '2025-10-10 12:35:53'),
(26, 30, 104, '2025-10-10 12:53:19'),
(28, 30, 109, '2025-10-10 12:53:33'),
(29, 30, 48, '2025-10-10 12:53:44'),
(33, 31, 109, '2025-10-10 13:55:01'),
(34, 31, 55, '2025-10-10 13:55:27'),
(40, 30, 113, '2025-10-10 14:37:30'),
(43, 30, 81, '2025-10-10 23:17:10'),
(46, 30, 102, '2025-10-10 23:32:49'),
(47, 30, 122, '2025-10-10 23:33:48'),
(48, 28, 77, '2025-10-12 16:40:33'),
(50, 28, 105, '2025-10-12 16:41:01'),
(51, 28, 109, '2025-10-12 16:41:08'),
(52, 28, 48, '2025-10-12 16:41:29'),
(53, 28, 52, '2025-10-12 18:14:19'),
(55, 28, 99, '2025-10-12 18:59:49'),
(59, 28, 111, '2025-10-12 19:19:24'),
(60, 28, 101, '2025-10-12 19:21:05'),
(63, 32, 109, '2025-10-12 23:57:38'),
(64, 33, 75, '2025-10-13 00:05:33'),
(65, 33, 109, '2025-10-13 00:05:54'),
(67, 32, 2, '2025-10-13 00:14:12'),
(68, 32, 75, '2025-10-13 00:14:26'),
(71, 34, 114, '2025-10-13 00:27:02'),
(72, 34, 109, '2025-10-13 00:27:12'),
(82, 42, 2, '2026-01-24 10:40:30'),
(84, 42, 109, '2026-01-24 10:40:53'),
(85, 42, 106, '2026-01-24 14:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Drinks', '', '2025-09-08 18:36:43'),
(2, 'Food', '', '2025-09-08 18:41:13'),
(25, 'pppp__OO__h__pp', '', '2026-01-26 17:46:35'),
(27, 'qqqq', '', '2026-01-27 20:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `sub_sub_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `sub_sub_category_id`, `name`, `description`, `ingredients`, `image`, `created_at`) VALUES
(2, 1, 'Drip Coffee', 'Classic, rich, and straightforward brew with a bold aroma and smooth finish.', 'Freshly ground coffee beans, hot water.', '1758459946_Drip_Coffee.png', '2025-09-20 12:49:16'),
(4, 2, 'Light Roast', 'Smooth and mild coffee with bright, delicate flavors. Perfect for a gentle morning boost.', '100% Arabica coffee beans, hot water.', '1758451197_Light_Roast.jpg', '2025-09-21 10:39:57'),
(41, 3, 'Earl Gray Tea', 'A premium black tea infused with natural bergamot oil, delivering a smooth, refreshing taste with a distinctive citrus aroma. Perfect for a refined tea experience any time of the day.', 'Black Tea, Natural Bergamot Oil', '1759321541_Earl_Gray_Tea.png', '2025-10-01 12:25:41'),
(44, 47, 'Iced Black Tea', 'A classic, refreshing drink made from rich black tea, brewed and served chilled over ice. Smooth, bold, and energizing — the perfect cool-down beverage for any time of the day.', 'Black Tea, Filtered Water, Ice, \r\n(Optional: Lemon or Sugar Syrup)', '1759329470_Iced_Black_Tea.png', '2025-10-01 14:37:50'),
(45, 52, 'Strawberry Smoothie', 'A creamy and refreshing blend of ripe strawberries, milk, and yogurt, naturally sweet and packed with flavor — the perfect fruity treat for any time of the day.', 'Fresh Strawberries, Milk (or Almond Milk), \r\nYogurt, Ice, (Optional: Honey or Sugar)', '1759330946_Strawbery_Smoothie.png', '2025-10-01 15:02:26'),
(46, 56, 'Orange Juice', 'Freshly squeezed orange juice, packed with vitamin C and natural sweetness. A refreshing, healthy choice to energize your day.', 'Fresh Oranges, Ice (optional)', '1759331133_Orange_Juice.png', '2025-10-01 15:05:33'),
(48, 60, 'Coffee Frappé', 'A chilled and creamy blended coffee drink, made with rich espresso, milk, and ice, topped with a light froth. Smooth, energizing, and perfect for hot days.', 'Espresso or Strong Coffee, Milk, \r\nIce, Sugar (optional)', '1759331536_Coffee_Frappé.png', '2025-10-01 15:12:16'),
(52, 1, 'Cafè Americano', 'A classic espresso-based drink made by diluting rich espresso shots with hot water, creating a smooth, bold flavor that’s less intense than straight espresso but still full of character.', 'Espresso, Hot Water', '1759332098_Cafe_Americano.png', '2025-10-01 15:21:38'),
(53, 67, 'Cheese Omelette', 'A fluffy, golden omelette filled with melted cheese for a rich, creamy taste. A simple yet delicious breakfast classic, served hot and satisfying.', 'Fresh Eggs, Cheese (Cheddar / Mozzarella), \r\nButter or Olive Oil, Salt & Black Pepper', '1759332356_Cheese_Omelette.png', '2025-10-01 15:25:56'),
(54, 70, 'Turkey Melt', 'A warm and savory sandwich made with sliced turkey, melted cheese, and golden-toasted bread. Perfectly hearty and comforting for lunch or dinner.', 'Sliced Turkey Breast, \r\nMelted Cheese (Cheddar / Swiss)\r\nToasted Bread, Butter\r\n(Optional: Tomato, Lettuce, Mustard, or Mayo)', '1759332531_Turkey_Melt.png', '2025-10-01 15:28:51'),
(55, 76, 'Cheese-Stuffed Brioche', 'A soft, buttery brioche bun filled with rich, melted cheese. Lightly golden on the outside, fluffy on the inside, and irresistibly cheesy — a perfect savory snack or breakfast treat.', 'A soft, buttery brioche bun filled with rich, melted cheese. Lightly golden on the outside, fluffy on the inside, and irresistibly cheesy — a perfect savory snack or breakfast treat.', '1759332664_Cheese-Stuffed_Brioche.png', '2025-10-01 15:31:04'),
(56, 78, 'Chocolate Fudge Cake', 'A rich, moist chocolate cake layered with smooth fudge frosting. Decadent, indulgent, and perfect for chocolate lovers — an irresistible dessert for any occasion.', 'Flour, Cocoa Powder, \r\nButter, Sugar, Eggs,\r\nDark Chocolate, \r\nCream (for fudge frosting)', '1759332828_Chocolate_Fudge_Cake.png', '2025-10-01 15:33:48'),
(57, 79, 'Classic Chocolate Brownie', 'A dense, fudgy brownie made with rich cocoa and real chocolate, baked to perfection with a slightly crisp top and a soft, gooey center. A timeless chocolate treat.', 'Dark Chocolate\r\nCocoa Powder, Butter\r\nSugar, Eggs\r\nFlour, Vanilla Extract', '1759339878_Classic_Chocolate_Brownie.png', '2025-10-01 17:31:18'),
(58, 2, 'Medium Roast', 'A perfectly balanced coffee with a smooth body, rich aroma, and mild acidity. Medium Roast brings out the natural flavors of the beans, offering a well-rounded cup that’s neither too light nor too dark.', '100% Arabica Coffee Beans (Medium Roast),\r\nFiltered Water', '1759359831_Medium_Roast.jpg', '2025-10-01 23:03:51'),
(59, 2, 'Dark Roast', 'Bold and intense, Dark Roast coffee offers a full-bodied flavor with deep, smoky notes and a smooth finish. Perfect for those who enjoy a strong, robust cup with low acidity.', '100% Arabica Coffee Beans (Dark Roast),\r\nFiltered Water', '1759359945_Dark_Roast.jpg', '2025-10-01 23:05:45'),
(60, 2, 'Brewed French Press', 'Freshly ground coffee steeped in hot water and pressed to perfection in a French Press. This method delivers a rich, full-bodied cup with bold flavor and aromatic oils preserved for a true coffee experience.', 'Freshly Ground Coffee (Medium or Dark Roast),\r\nHot Water', '1759360100_Brewed_French_Press.jpg', '2025-10-01 23:08:20'),
(61, 4, 'Cappuccino', 'A classic Italian coffee made with a perfect balance of rich espresso, steamed milk, and a thick layer of creamy milk foam on top. Smooth, aromatic, and comforting — a timeless coffee favorite.', 'Espresso, Steamed Milk, Milk Foam', '1759360308_Cappuccino.png', '2025-10-01 23:11:48'),
(62, 4, 'Dry Cappuccino', 'A bold twist on the classic cappuccino, made with a shot of rich espresso and topped mainly with thick milk foam and very little steamed milk. Stronger in coffee flavor, lighter in texture, and perfect for those who love a more intense', 'Espresso, Milk Foam (thick), \r\nMinimal Steamed Milk', '1759360561_Dry_Cappuccino.png', '2025-10-01 23:16:01'),
(63, 4, 'Wet Cappuccino', 'A smoother variation of the classic cappuccino, made with espresso, more steamed milk, and less milk foam. Creamier in texture with a milder coffee taste — ideal for those who enjoy a softer, balanced cup.', 'Espresso\r\n\r\nSteamed Milk (more)\r\n\r\nLight Milk Foam', '1759360690_Wet_Cappuccino.png', '2025-10-01 23:18:10'),
(64, 4, 'Iced Cappuccino', 'A refreshing twist on the classic cappuccino — made with rich espresso, chilled milk, and topped with a layer of cold milk foam over ice. Smooth, creamy, and perfectly cooling for warm days.', 'Espresso, Cold Milk, Milk Foam, Ice', '1759360827_Iced_Cappuccino.png', '2025-10-01 23:20:27'),
(65, 5, 'Caramel Latte', 'A smooth blend of rich espresso and steamed milk, sweetened with velvety caramel syrup and topped with a light milk foam. Sweet, creamy, and indulgent — a perfect treat for any coffee lover.', 'Espresso, Steamed Milk, \r\nCaramel Syrup, Milk Foam, \r\n(Optional: Whipped Cream & Caramel Drizzle)', '1759361150_Caramel_Latte.png', '2025-10-01 23:25:50'),
(66, 5, 'Vanille Latte', 'A comforting mix of bold espresso and steamed milk, infused with smooth vanilla syrup and topped with a light layer of milk foam. Creamy, aromatic, and perfectly balanced with a hint of sweetness.', 'Espresso, Steamed Milk, \r\nVanilla Syrup, Milk Foam, \r\n(Optional: Whipped Cream & Vanilla Drizzle)', '1759361270_Vanille_Latte.png', '2025-10-01 23:27:50'),
(67, 5, 'Spanish Latte', 'A rich and creamy coffee drink made with bold espresso, steamed milk, and a touch of sweetened condensed milk for a smooth, velvety sweetness. A perfect balance between strong coffee flavor and indulgent creaminess.', 'Espresso, Steamed Milk, \r\nSweetened Condensed Milk', '1759361378_Spanish_Latte.png', '2025-10-01 23:29:38'),
(68, 5, 'Hazelnut Latte', 'A smooth and aromatic coffee drink made with rich espresso, steamed milk, and sweet hazelnut syrup, topped with a light milk foam. Nutty, creamy, and perfectly comforting.', 'Espresso, Steamed Milk, \r\nHazelnut Syrup, Milk Foam\r\n(Optional: Whipped Cream & Crushed Hazelnuts)', '1759361559_Hazelnut_Latte.jpg', '2025-10-01 23:32:39'),
(69, 8, 'Espresso', 'A concentrated shot of rich, bold coffee brewed under high pressure. Full-bodied, aromatic, and intense — the purest expression of coffee.', '100% Arabica Coffee Beans (Finely Ground),\r\nHot Water', '1759361692_Espresso.jpg', '2025-10-01 23:34:52'),
(70, 8, 'Espresso Macchiato', 'A bold shot of espresso “stained” with a small dollop of milk foam. Strong, rich, and slightly softened by the creaminess of the milk — perfect for espresso lovers who enjoy a touch of smoothness.', 'Espresso, Milk Foam', '1759361819_Espresso_Macchiato.png', '2025-10-01 23:36:59'),
(71, 8, 'Espresso Con Pana', 'A rich shot of espresso topped with a swirl of fresh whipped cream. Bold and intense coffee flavor perfectly balanced with a creamy, sweet finish — a delightful Italian classic.', 'Espresso, Whipped Cream', '1759361930_Espresso_Con_Pana.png', '2025-10-01 23:38:50'),
(72, 48, 'Caffè Mocha', 'A delicious fusion of bold espresso, rich chocolate, and steamed milk, topped with milk foam or whipped cream. Creamy, sweet, and indulgent — the perfect choice for coffee and chocolate lovers alike.', 'Espresso, Steamed Milk,\r\nChocolate Syrup or Cocoa,\r\nMilk Foam / Whipped Cream (optional)', '1759362068_Caffè_Mocha.jpg', '2025-10-01 23:41:08'),
(73, 48, 'White Mocha', 'A smooth and creamy blend of rich espresso, velvety steamed milk, and sweet white chocolate sauce. Balanced and indulgent, with a softer, sweeter taste than classic mocha.', 'Espresso, Steamed Milk,\r\nWhite Chocolate Sauce,\r\nMilk Foam / Whipped Cream (optional)', '1759362188_White_Mocha.jpg', '2025-10-01 23:43:08'),
(74, 48, 'Iced Mocha', 'A refreshing mix of bold espresso, chilled milk, and rich chocolate sauce, poured over ice for a perfect balance of smooth and sweet flavors.', 'Espresso, Cold Milk, \r\nChocolate Sauce, Ice, \r\nWhipped Cream (optional)', '1759362302_Iced_Mocha.jpg', '2025-10-01 23:45:02'),
(75, 49, 'Hot Chocolate', 'A rich and comforting drink made with steamed milk and smooth cocoa, topped with creamy foam or whipped cream. Perfect for a cozy treat.', 'Steamed Milk, Cocoa / Chocolate Sauce, \r\nSugar (optional), Whipped Cream (optional)', '1759362430_Hot_Chocolate.png', '2025-10-01 23:47:10'),
(76, 49, 'White Hot Chocolate', 'A smooth and creamy twist on the classic hot chocolate, made with steamed milk and sweet white chocolate, topped with velvety foam or whipped cream for an indulgent treat.', 'Steamed Milk, White Chocolate Sauce, \r\nSugar (optional), Whipped Cream (optional)', '1759362523_White_Hot_Chocolate.png', '2025-10-01 23:48:43'),
(77, 3, 'Royal English Breakfast Tea', 'A robust and full-bodied black tea blend, rich in flavor and perfect to start the day. Smooth, malty, and energizing, best enjoyed plain or with milk and sugar.', 'Premium Black Tea Leaves', '1759488969_Royal_English_Breakfast_Tea.png', '2025-10-03 10:56:09'),
(78, 3, 'Green Tea', 'A light, refreshing tea with delicate grassy notes and a smooth finish. Known for its natural antioxidants and calming effect, perfect for a healthy pick-me-up.', 'Premium Green Tea Leaves', '1759489091_Green_Tea.png', '2025-10-03 10:58:11'),
(79, 3, 'Mint Tea', 'A refreshing and soothing herbal tea infused with fresh mint leaves, offering a cooling taste and calming aroma. Perfect for relaxation or a light refreshment.', 'Fresh Mint Leaves,\r\nHot Water, \r\n(Optional) Honey or Lemon', '1759489237_Mint_Tea.png', '2025-10-03 11:00:37'),
(80, 3, 'Mellow Mango With Zinc', 'A tropical, fruity blend bursting with the sweetness of ripe mango, enriched with a boost of zinc to support wellness and immunity. Smooth, refreshing, and packed with flavor.', 'Mango Purée / Juice,\r\nWater or Sparkling Water,\r\nNatural Sweetener (optional),\r\nZinc Supplement', '1759489371_Mellow_Mango_With_Zinc.png', '2025-10-03 11:02:51'),
(81, 6, 'Cold Coffee', 'A chilled and refreshing coffee drink made by blending rich brewed coffee with cold milk and ice. Smooth, creamy, and energizing — the perfect pick-me-up on a hot day.', 'Brewed Coffee, \r\nCold Milk, Ice, \r\nSugar / Sweetener (optional)', '1759489560_Cold_Coffe.png', '2025-10-03 11:06:00'),
(82, 6, 'Iced Cappuccino', 'A refreshing twist on the classic cappuccino — bold espresso combined with cold milk and poured over ice, topped with a light frothy foam for a smooth and cooling coffee experience.', 'Espresso, Cold Milk, \r\nIce, Milk Foam', '1759489700_Iced_Cappuccino.png', '2025-10-03 11:08:20'),
(83, 6, 'Iced Mocha', 'A perfect balance of bold espresso, smooth milk, and rich chocolate sauce, served over ice for a refreshing and indulgent coffee treat.', 'Espresso, Cold Milk\r\nChocolate Sauce, Ice,\r\nWhipped Cream (optional)', '1759489849_Iced_Mocha.jpg', '2025-10-03 11:10:49'),
(84, 6, 'Iced Espresso', 'A bold and energizing coffee made by pouring freshly brewed espresso shots over ice. Strong, smooth, and refreshing — perfect for a quick caffeine boost', 'Espresso Shots, Ice\r\n(Optional) Sugar or Sweetener', '1759492942_Iced_Espresso.png', '2025-10-03 12:02:22'),
(85, 6, 'Iced Shaken Espresso', 'A smooth and refreshing coffee made by shaking bold espresso shots with ice and a hint of sweetener, then topped with a splash of milk for a perfectly balanced taste. Light, frothy, and energizing.', 'Espresso Shots\r\nIce, Classic Syrup / Sugar, \r\nA Splash of Milk (optional)', '1759493078_Iced_Shaken_Espresso.png', '2025-10-03 12:04:38'),
(86, 6, 'Iced Caffè Americano', 'Bold espresso shots blended with cold water and poured over ice for a smooth, refreshing, and energizing coffee experience.', 'Espresso Shots\r\nCold Water, Ice', '1759493509_Iced_Americano.png', '2025-10-03 12:11:49'),
(87, 7, 'Cold Brew', 'A smooth, naturally sweet coffee made by steeping freshly ground beans in cold water for hours. Less acidic than iced coffee, rich in flavor, and deeply refreshing.', 'Coarse-Ground Coffee Beans, \r\nCold Water, \r\nIce', '1759493645_Cold_Brew.png', '2025-10-03 12:14:05'),
(88, 7, 'Smooth Vanille Cold Brew', 'A rich and mellow cold brew coffee infused with smooth vanilla syrup, served over ice. Naturally sweet, refreshing, and perfectly balanced for a delightful coffee experience.', 'Cold Brew Coffee, \r\nVanilla Syrup, \r\nIce, \r\n(Optional) Splash of Milk or Cream', '1759493780_Smooth_Vanille_Cold_Brew.png', '2025-10-03 12:16:20'),
(89, 7, 'Chocolate Cream Cold Brew', 'A bold and refreshing cold brew topped with silky chocolate cream, blending smooth coffee with a rich, sweet cocoa finish. Perfectly indulgent yet refreshing.', 'Cold Brew Coffee, \r\nChocolate Cream Foam, \r\nIce, \r\n(Optional) Cocoa Powder Dusting', '1759493909_Chocolate_Cream_Cold_Brew.png', '2025-10-03 12:18:29'),
(90, 7, 'Nondairy Smooth Vanille Cold Brew', 'A silky and refreshing cold brew infused with smooth vanilla flavor, crafted with non-dairy milk alternatives for a light, creamy taste without dairy. Perfect for those seeking a plant-based twist on classic cold brew.', 'Cold Brew Coffee, \r\nVanilla Syrup, \r\nNon-Dairy Milk (Oat, Almond, or Soy), \r\nIce', '1759494032_Nondairy_Smooth_Vanille_Cold_Brew.png', '2025-10-03 12:20:32'),
(91, 50, 'Nitro Cold Brew', 'A rich and velvety cold brew coffee infused with nitrogen for a naturally creamy texture and cascading finish. Smooth, bold, and refreshing with zero added sugar.', 'Cold Brew Coffee, \r\nNitrogen Infusion, \r\nIce (optional, often served without)', '1759494141_Nitro_Cold_Brew.png', '2025-10-03 12:22:21'),
(92, 50, 'Vanilla Sweet Cream Nitro Cold Brew', 'A smooth and creamy twist on classic nitro cold brew — infused with nitrogen for a velvety texture and topped with a swirl of sweet vanilla cream. Balanced, bold, and naturally indulgent.', 'Nitro Cold Brew Coffee\r\nVanilla Syrup, \r\nSweet Cream, \r\n(Optional) Ice (often served without)', '1759494248_Vanilla_Sweet_Cream_Nitro_Cold_Brew.png', '2025-10-03 12:24:08'),
(93, 50, 'Salted Caramel Nitro Cold Brew', 'A bold and velvety nitro cold brew infused with the rich sweetness of caramel and a touch of sea salt, topped with creamy foam for a perfectly smooth and indulgent balance of flavors.', 'Nitro Cold Brew Coffee\r\nCaramel Syrup, \r\nSea Salt, \r\nSweet Cream Foam (optional)', '1759494346_Salted_Caramel_Nitro_Cold_Brew.jpg', '2025-10-03 12:25:46'),
(94, 51, 'Iced Vanille Latte', 'A refreshing espresso-based drink made with bold espresso, chilled milk, and sweet vanilla syrup, served over ice for a smooth and flavorful coffee experience.', 'Espresso, \r\nCold Milk, \r\nVanilla Syrup, \r\nIce', '1759494464_Iced_Vanille_Latte.jpg', '2025-10-03 12:27:44'),
(95, 51, 'Iced Caramel Latte', 'A smooth and refreshing espresso-based drink made with rich espresso, chilled milk, and sweet caramel syrup, poured over ice and topped with a drizzle of caramel for an indulgent finish.', 'Espresso\r\nCold Milk, \r\nCaramel Syrup, \r\nIce, \r\nCaramel Drizzle (optional)', '1759494598_Iced_Caramel_Latte.jpg', '2025-10-03 12:29:58'),
(96, 51, 'Iced Cinnamon Latte', 'A creamy iced latte blended with espresso, cold milk, and a touch of sweet cinnamon syrup, finished with a sprinkle of ground cinnamon for a warm yet refreshing twist.', 'Espresso, \r\nCold Milk, \r\nCinnamon Syrup, \r\nIce, \r\nGround Cinnamon (topping)', '1759494710_Iced_Cinnamon_Latte.jpg', '2025-10-03 12:31:50'),
(97, 47, 'Iced Black Milk Tea', 'A refreshing blend of strong-brewed black tea, smooth milk, and a touch of sweetness, poured over ice for a creamy and energizing drink.', 'Black Tea (brewed & chilled), \r\nFresh Milk, \r\nSugar Syrup (optional, adjustable), \r\nIce', '1759494902_Iced_Black_Milk_Tea.png', '2025-10-03 12:35:02'),
(98, 47, 'Iced Black Tea Lemonade', 'A refreshing fusion of bold black tea and zesty lemonade, served over ice for the perfect balance of smooth and tangy flavors.', 'Freshly brewed black tea (chilled), \r\nFresh lemonade, \r\nIce, \r\nOptional sweetener (simple syrup or honey)', '1759495002_Iced_Black_Tea_Lemonade.png', '2025-10-03 12:36:42'),
(99, 47, 'Iced Green Tea', 'A light and refreshing beverage made with freshly brewed green tea, chilled and served over ice. Smooth, crisp, and naturally uplifting.', 'Freshly brewed green tea (chilled), \r\nIce, \r\nOptional sweetener (honey or syrup)', '1759495110_Iced_Green_Tea.png', '2025-10-03 12:38:30'),
(100, 47, 'Iced Matcha Tea', 'A vibrant, refreshing drink made with finely ground matcha green tea whisked with water and poured over ice. Smooth, earthy, and packed with natural energy.', 'Premium Matcha Green Tea Powder, \r\nCold water, \r\nIce, \r\n(Optional) Sweetener or a splash of milk', '1759495221_Iced_Matcha_Tea.png', '2025-10-03 12:40:21'),
(101, 47, 'Iced Matcha Latte', 'A creamy and energizing drink made with premium matcha green tea blended with chilled milk and poured over ice. Smooth, earthy, and lightly sweet — the perfect balance of freshness and indulgence.', 'Matcha Green Tea Powder, \r\nCold Milk (whole / skim / non-dairy options), \r\nIce, \r\n(Optional) Sweetener (syrup or honey)', '1759495354_Iced_Matcha_Latte.png', '2025-10-03 12:42:34'),
(102, 52, 'Mango Smoothie', 'A tropical delight made with ripe, juicy mangoes blended to perfection with ice and a creamy base. Refreshing, naturally sweet, and packed with vitamins — the ultimate sunshine in a cup.', 'Fresh Mango / Mango Purée, \r\nIce, \r\nYogurt or Milk (dairy / non-dairy options),\r\nHoney or Syrup (optional for sweetness)', '1759495562_Mango_Smoothie.png', '2025-10-03 12:46:02'),
(103, 52, 'Banana Smoothie', 'A creamy and energizing blend of ripe bananas, milk, and ice — smooth, naturally sweet, and rich in potassium. Perfect as a refreshing treat or a light energy boost.', 'Fresh Ripe Bananas, \r\nMilk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759495683_banana_Smoothie.png', '2025-10-03 12:48:03'),
(104, 52, 'Fruit Mix Smoothie', 'A colorful and refreshing blend of assorted seasonal fruits, mixed with yogurt and ice for a naturally sweet, creamy, and vitamin-packed smoothie. Perfect for a healthy and energizing boost.', 'Mixed Fresh Fruits (e.g. mango, banana, strawberry, berries), \r\nYogurt or Milk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759495804_Fruit_Mix_Smoothie.png', '2025-10-03 12:50:04'),
(105, 52, 'Blueberry Smoothie', 'A rich and refreshing blend of ripe blueberries, yogurt, and ice — creamy, naturally sweet, and packed with antioxidants for a deliciously healthy boost.', 'Fresh or Frozen Blueberries\r\nYogurt or Milk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759495923_Bluebery_Smoothie.png', '2025-10-03 12:52:03'),
(106, 52, 'Mixberry Smoothie', 'A refreshing and tangy blend of strawberries, blueberries, raspberries, and blackberries, mixed with yogurt and ice for a creamy, antioxidant-rich treat. Perfect for a fruity energy boost any time of the day.', 'Fresh or Frozen Mixed Berries \r\n(strawberry, blueberry, raspberry, blackberry), \r\nYogurt or Milk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759496100_Mix_berry_Smoothie.png', '2025-10-03 12:55:00'),
(107, 52, 'Kiwi Smoothie', 'A zesty and refreshing smoothie made with fresh kiwi blended with yogurt and ice. Naturally tangy, slightly sweet, and packed with vitamin C — the perfect energizing tropical treat.', 'Fresh Ripe Kiwi, \r\nYogurt or Milk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759496210_Kiwi_Smoothie.png', '2025-10-03 12:56:50'),
(108, 52, 'Avocado Smoothie', 'A rich, creamy smoothie made with fresh avocado blended with milk and ice. Smooth, nourishing, and packed with healthy fats — a perfect choice for a filling and energizing treat.', 'Fresh Avocado, \r\nMilk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional for sweetness)', '1759496352_Avocado_Smoothie.png', '2025-10-03 12:59:12'),
(109, 52, 'Coconut Smoothie', 'A creamy tropical smoothie made with fresh coconut blended with milk and ice. Lightly sweet, refreshing, and packed with natural energy — a perfect escape in every sip.', 'Fresh Coconut Flesh or Coconut Milk, \r\nIce, \r\nMilk (dairy / non-dairy options), \r\nHoney or Syrup (optional)', '1759496469_Coconut_Smoothie.png', '2025-10-03 13:01:09'),
(110, 53, 'Green Detox Smoothie', 'A refreshing and nutrient-packed smoothie made with leafy greens, fresh fruits, and a touch of citrus. Light, energizing, and perfect for a natural detox boost.', 'Spinach or Kale, \r\nGreen Apple, \r\nCucumber, \r\nKiwi or Pineapple (optional for sweetness), \r\nLemon Juice, \r\nIce, \r\nHoney (optional)', '1759496630_Green_Detox_Smoothie.png', '2025-10-03 13:03:50'),
(111, 54, 'Strawberry Banana Yogurt Smoothie', 'A creamy, fruity blend of ripe bananas and sweet strawberries mixed with yogurt and ice. Smooth, refreshing, and packed with natural sweetness and protein — a classic favorite for all ages.', 'Fresh Strawberries, \r\nRipe Banana, \r\nYogurt (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759496757_Strawberry_Banana_Yogurt_Smoothie.png', '2025-10-03 13:05:57'),
(112, 54, 'Peach Yogurt Smoothie', 'A smooth and refreshing blend of ripe peaches, creamy yogurt, and ice. Naturally sweet, tangy, and packed with vitamins — a perfect balance of flavor and nourishment.', 'Fresh or Frozen Peaches, \r\nYogurt (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759496903_Peach_Yogurt_Smoothie.png', '2025-10-03 13:08:23'),
(113, 55, 'Chocolate Banana Protein Smoothie', 'A rich and energizing smoothie made with ripe bananas, cocoa, protein powder, and milk. Creamy, chocolatey, and packed with protein — perfect as a post-workout fuel or a filling snack.', 'Ripe Banana, \r\nCocoa Powder / Chocolate Syrup, \r\nProtein Powder (whey / plant-based), \r\nMilk (dairy / non-dairy options), \r\nIce, \r\nHoney or Syrup (optional)', '1759497035_Chocolate_Banana_Protein_Smoothie.png', '2025-10-03 13:10:35'),
(114, 55, 'Peanut Butter Protein Smoothie', 'A creamy, protein-packed smoothie made with rich peanut butter, protein powder, milk, and ice. Nutty, satisfying, and energizing — the perfect choice for a post-workout boost or a filling healthy snack.', 'Natural Peanut Butter, \r\nProtein Powder (whey / plant-based), \r\nMilk (dairy / non-dairy options), \r\nIce, \r\nBanana (optional for extra creaminess), \r\nHoney or Syrup (optional)', '1759497158_Peanut_Butter_Protein_Smoothie.png', '2025-10-03 13:12:38'),
(115, 56, 'Watermelon Juice', 'A naturally sweet and refreshing juice made with freshly blended watermelon, served chilled over ice. Light, hydrating, and the perfect summer cooler.', 'Fresh Watermelon, \r\nIce, \r\n(Optional) Mint leaves or Lemon splash for extra freshness', '1759508945_Watermelon_Juice.png', '2025-10-03 16:29:05'),
(116, 56, 'Appel Juice', 'Freshly pressed apple juice with a crisp, sweet flavor — naturally hydrating and rich in vitamins. A simple, clean drink with no fuss.', 'Fresh Apples (pressed), \r\nWater (if needed), \r\nIce (optional), \r\nOptional: Sweetener or lemon slice', '1759509169_Appel_Juice.png', '2025-10-03 16:32:49'),
(117, 57, 'Lemonade', 'A zesty and refreshing drink made with freshly squeezed lemons, water, and just the right touch of sweetness. Perfectly chilled for a crisp and revitalizing summer classic.', 'Fresh Lemon Juice, \r\nWater (still or sparkling), \r\nSugar or Honey (adjusted for sweetness), \r\nIce', '1759509907_Lemonade.png', '2025-10-03 16:45:07'),
(118, 57, 'Mint Lemonade', 'A cool and zesty twist on the classic lemonade — freshly squeezed lemons blended with garden-fresh mint and served over ice. Refreshing, tangy, and perfectly energizing.', 'Fresh Lemon Juice, \r\nFresh Mint Leaves, \r\nWater (still or sparkling), \r\nSugar or Honey (to taste), \r\nIce', '1759510045_Mint_Lemonade.png', '2025-10-03 16:47:25'),
(119, 57, 'Orange & Limon Mix', 'A vibrant citrus fusion of freshly squeezed oranges and tangy lemons, perfectly balanced for a refreshing and energizing taste. Served chilled over ice for a zesty boost.', 'Fresh Orange Juice, \r\nFresh Lemon Juice, \r\nSugar or Honey (optional, to balance acidity), \r\nIce', '1759510573_Orange_&_Limon_Mix.png', '2025-10-03 16:56:13'),
(120, 58, 'Mint Water', 'A light and refreshing drink made with fresh mint leaves infused in chilled water. Naturally cooling, hydrating, and perfect for a healthy, calming refreshment.', 'Fresh Mint Leaves, \r\nChilled Water, \r\nIce, \r\n(Optional) Lemon Slice for extra zest', '1759510782_Mint_Water.png', '2025-10-03 16:59:42'),
(121, 58, 'Limon Water', 'Refreshing water infused with lemon slices, light and hydrating.', 'Fresh lemon slices, \r\nChilled water, \r\nIce', '1759511010_Limon_Water.png', '2025-10-03 17:03:30'),
(122, 58, 'Strawberry & Lime detox Water', 'A refreshing detox water infused with fresh strawberries and lime slices. Light, hydrating, and naturally flavorful.', 'Fresh strawberries, \r\nFresh lime slices, \r\nChilled water, \r\nIce', '1759511214_Strawberry_&_Lime_detox_Water.png', '2025-10-03 17:06:54'),
(123, 59, 'Appel Cooler', 'A chilled and refreshing apple drink made with fresh apple juice, lightly sweetened and served over ice. Smooth, crisp, and naturally energizing.', 'Fresh apple juice, \r\nChilled water, \r\nIce, \r\nOptional: sugar or honey', '1759511499_Appel_Cooler.png', '2025-10-03 17:11:39'),
(124, 59, 'Cucumber Splash', 'A light and refreshing drink made with chilled water and fresh cucumber slices. Naturally hydrating and perfect for a cool, revitalizing sip.', 'Fresh cucumber slices, \r\nChilled water, \r\nIce, \r\nOptional: lemon slice for extra zest', '1759512339_Cucumber_Splash.png', '2025-10-03 17:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_size_price`
--

CREATE TABLE `menu_item_size_price` (
  `id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_size_price`
--

INSERT INTO `menu_item_size_price` (`id`, `menu_item_id`, `size`, `price`) VALUES
(4, 2, 'small', 2.87),
(5, 2, 'medium', 3.00),
(6, 2, 'large', 4.00),
(7, 4, 'small', 2.50),
(8, 4, 'medium', 3.50),
(9, 4, 'large', 4.50),
(58, 41, 'small', 3.99),
(59, 41, 'medium', 6.67),
(60, 41, 'large', 11.00),
(67, 44, 'small', 2.68),
(68, 44, 'medium', 4.50),
(69, 44, 'large', 6.00),
(70, 45, 'small', 4.66),
(71, 45, 'medium', 5.99),
(72, 45, 'large', 7.20),
(73, 46, 'small', 2.79),
(74, 46, 'medium', 3.55),
(75, 46, 'large', 4.99),
(79, 48, 'small', 3.49),
(80, 48, 'medium', 4.49),
(81, 48, 'large', 5.49),
(85, 52, 'small', 2.86),
(86, 52, 'medium', 3.24),
(87, 52, 'large', 3.99),
(88, 53, 'small', 4.99),
(89, 53, 'medium', 0.00),
(90, 53, 'large', 5.99),
(91, 54, 'small', 6.99),
(92, 54, 'medium', 0.00),
(93, 54, 'large', 8.49),
(94, 55, 'small', 3.49),
(95, 55, 'medium', 9.49),
(96, 55, 'large', 17.99),
(97, 56, 'small', 4.99),
(98, 56, 'medium', 18.99),
(99, 56, 'large', 29.99),
(100, 57, 'small', 2.99),
(101, 57, 'medium', 10.99),
(102, 57, 'large', 19.99),
(103, 58, 'small', 2.99),
(104, 58, 'medium', 3.49),
(105, 58, 'large', 3.99),
(106, 59, 'small', 3.29),
(107, 59, 'medium', 3.79),
(108, 59, 'large', 4.29),
(109, 60, 'small', 3.49),
(110, 60, 'medium', 3.99),
(111, 60, 'large', 4.49),
(112, 61, 'small', 3.49),
(113, 61, 'medium', 3.99),
(114, 61, 'large', 4.49),
(115, 62, 'small', 3.59),
(116, 62, 'medium', 4.09),
(117, 62, 'large', 4.59),
(118, 63, 'small', 3.59),
(119, 63, 'medium', 4.00),
(120, 63, 'large', 4.69),
(121, 64, 'small', 3.79),
(122, 64, 'medium', 4.20),
(123, 64, 'large', 4.70),
(124, 65, 'small', 3.99),
(125, 65, 'medium', 4.49),
(126, 65, 'large', 5.11),
(127, 66, 'small', 3.99),
(128, 66, 'medium', 4.49),
(129, 66, 'large', 5.11),
(130, 67, 'small', 4.29),
(131, 67, 'medium', 4.79),
(132, 67, 'large', 5.19),
(133, 68, 'small', 3.99),
(134, 68, 'medium', 4.44),
(135, 68, 'large', 4.99),
(136, 69, 'small', 2.29),
(137, 69, 'medium', 2.79),
(138, 69, 'large', 3.29),
(139, 70, 'small', 2.49),
(140, 70, 'medium', 2.99),
(141, 70, 'large', 3.39),
(142, 71, 'small', 2.69),
(143, 71, 'medium', 3.19),
(144, 71, 'large', 3.78),
(145, 72, 'small', 4.29),
(146, 72, 'medium', 4.79),
(147, 72, 'large', 5.29),
(148, 73, 'small', 4.49),
(149, 73, 'medium', 4.99),
(150, 73, 'large', 5.49),
(151, 74, 'small', 4.29),
(152, 74, 'medium', 4.69),
(153, 74, 'large', 5.19),
(154, 75, 'small', 3.79),
(155, 75, 'medium', 4.29),
(156, 75, 'large', 4.79),
(157, 76, 'small', 3.99),
(158, 76, 'medium', 4.49),
(159, 76, 'large', 4.99),
(160, 77, 'small', 2.69),
(161, 77, 'medium', 3.19),
(162, 77, 'large', 3.75),
(163, 78, 'small', 2.49),
(164, 78, 'medium', 2.89),
(165, 78, 'large', 3.33),
(166, 79, 'small', 2.79),
(167, 79, 'medium', 3.19),
(168, 79, 'large', 3.69),
(169, 80, 'small', 3.99),
(170, 80, 'medium', 4.49),
(171, 80, 'large', 4.99),
(172, 81, 'small', 3.49),
(173, 81, 'medium', 3.99),
(174, 81, 'large', 4.49),
(175, 82, 'small', 3.99),
(176, 82, 'medium', 4.49),
(177, 82, 'large', 4.99),
(178, 83, 'small', 4.29),
(179, 83, 'medium', 4.79),
(180, 83, 'large', 5.29),
(181, 84, 'small', 2.98),
(182, 84, 'medium', 3.69),
(183, 84, 'large', 4.26),
(184, 85, 'small', 3.49),
(185, 85, 'medium', 3.99),
(186, 85, 'large', 4.49),
(187, 86, 'small', 3.19),
(188, 86, 'medium', 3.89),
(189, 86, 'large', 4.59),
(190, 87, 'small', 3.49),
(191, 87, 'medium', 4.29),
(192, 87, 'large', 4.99),
(193, 88, 'small', 3.89),
(194, 88, 'medium', 4.59),
(195, 88, 'large', 5.29),
(196, 89, 'small', 4.19),
(197, 89, 'medium', 4.89),
(198, 89, 'large', 5.59),
(199, 90, 'small', 4.29),
(200, 90, 'medium', 4.99),
(201, 90, 'large', 5.69),
(202, 91, 'small', 4.49),
(203, 91, 'medium', 5.19),
(204, 91, 'large', 5.89),
(205, 92, 'small', 4.79),
(206, 92, 'medium', 5.49),
(207, 92, 'large', 6.19),
(208, 93, 'small', 4.99),
(209, 93, 'medium', 5.69),
(210, 93, 'large', 6.39),
(211, 94, 'small', 4.09),
(212, 94, 'medium', 4.79),
(213, 94, 'large', 5.39),
(214, 95, 'small', 4.19),
(215, 95, 'medium', 4.89),
(216, 95, 'large', 5.49),
(217, 96, 'small', 4.29),
(218, 96, 'medium', 4.99),
(219, 96, 'large', 5.59),
(220, 97, 'small', 3.79),
(221, 97, 'medium', 4.39),
(222, 97, 'large', 4.99),
(223, 98, 'small', 3.99),
(224, 98, 'medium', 4.59),
(225, 98, 'large', 5.19),
(226, 99, 'small', 3.49),
(227, 99, 'medium', 4.29),
(228, 99, 'large', 5.09),
(229, 100, 'small', 4.19),
(230, 100, 'medium', 4.89),
(231, 100, 'large', 5.79),
(232, 101, 'small', 4.79),
(233, 101, 'medium', 5.49),
(234, 101, 'large', 6.39),
(235, 102, 'small', 4.59),
(236, 102, 'medium', 5.29),
(237, 102, 'large', 6.19),
(238, 103, 'small', 4.39),
(239, 103, 'medium', 5.09),
(240, 103, 'large', 5.99),
(241, 104, 'small', 4.89),
(242, 104, 'medium', 5.69),
(243, 104, 'large', 6.59),
(244, 105, 'small', 4.99),
(245, 105, 'medium', 5.79),
(246, 105, 'large', 6.69),
(247, 106, 'small', 5.19),
(248, 106, 'medium', 5.99),
(249, 106, 'large', 6.89),
(250, 107, 'small', 4.79),
(251, 107, 'medium', 5.59),
(252, 107, 'large', 6.49),
(253, 108, 'small', 5.29),
(254, 108, 'medium', 6.09),
(255, 108, 'large', 6.99),
(256, 109, 'small', 4.99),
(257, 109, 'medium', 5.79),
(258, 109, 'large', 6.69),
(259, 110, 'small', 5.19),
(260, 110, 'medium', 5.99),
(261, 110, 'large', 6.89),
(262, 111, 'small', 4.79),
(263, 111, 'medium', 5.59),
(264, 111, 'large', 6.49),
(265, 112, 'small', 4.99),
(266, 112, 'medium', 5.79),
(267, 112, 'large', 6.69),
(268, 113, 'small', 5.49),
(269, 113, 'medium', 6.29),
(270, 113, 'large', 7.19),
(271, 114, 'small', 5.79),
(272, 114, 'medium', 6.59),
(273, 114, 'large', 7.49),
(274, 115, 'small', 3.79),
(275, 115, 'medium', 4.39),
(276, 115, 'large', 5.09),
(277, 116, 'small', 3.29),
(278, 116, 'medium', 3.99),
(279, 116, 'large', 4.69),
(280, 117, 'small', 2.99),
(281, 117, 'medium', 3.79),
(282, 117, 'large', 4.59),
(283, 118, 'small', 3.29),
(284, 118, 'medium', 4.19),
(285, 118, 'large', 4.99),
(286, 119, 'small', 3.49),
(287, 119, 'medium', 4.39),
(288, 119, 'large', 5.19),
(289, 120, 'small', 1.99),
(290, 120, 'medium', 2.49),
(291, 120, 'large', 2.99),
(292, 121, 'small', 1.50),
(293, 121, 'medium', 2.00),
(294, 121, 'large', 2.60),
(295, 122, 'small', 2.20),
(296, 122, 'medium', 2.90),
(297, 122, 'large', 3.50),
(298, 123, 'small', 3.30),
(299, 123, 'medium', 3.90),
(300, 123, 'large', 4.70),
(301, 124, 'small', 2.50),
(302, 124, 'medium', 3.20),
(303, 124, 'large', 3.90);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','processing','completed','canceled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('cash','card','wallet') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_details`
--

CREATE TABLE `staff_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `shift` enum('morning','evening','night') DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `main_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `main_category_id`, `name`, `description`, `image`, `created_at`) VALUES
(1, 1, 'Hot Coffee', '', '1757357985_Hot_Coffee.png', '2025-09-08 18:59:45'),
(2, 1, 'Hot Tea', '', '1757358002_Hot_Tea.png', '2025-09-08 19:00:02'),
(3, 2, 'Breakfast', '', '1757358017_Breakfast.png', '2025-09-08 19:00:17'),
(4, 1, 'Cold Coffee', '', '1757367938_Cold_Coffe.png', '2025-09-08 21:45:38'),
(26, 1, 'Cold Tea', '', '1759323803_Cold_Tea.png', '2025-10-01 13:03:23'),
(27, 1, 'Smoothies', '', '1759324027_Smoothies.png', '2025-10-01 13:07:07'),
(28, 1, 'Speacialty Drinks', '', '1759324050_Speacialty_Drinks.png', '2025-10-01 13:07:30'),
(29, 1, 'Fresh Drinks', '', '1759324087_Fresh_Drink.png', '2025-10-01 13:08:07'),
(30, 1, 'Frappe', '', '1759324111_Frappé.png', '2025-10-01 13:08:31'),
(31, 1, 'Water And Soft Drinks', '', '1759324162_Water_&_Soft_Drinks.jpg', '2025-10-01 13:09:22'),
(32, 2, 'Lunch', '', '1759324207_Lunch.png', '2025-10-01 13:10:07'),
(35, 2, 'Bread', '', '1759324367_Bread.png', '2025-10-01 13:12:47'),
(36, 2, 'Sweets And Desserts', '', '1759324426_Sweet.jpg', '2025-10-01 13:13:46'),
(40, 25, 'ddd__p__d_goo__', '', '1769449605_DSC_8064 copy.jpg', '2026-01-26 17:46:45'),
(41, 25, 'iiiii', '', '1769543997_DSC_8064 copy.jpg', '2026-01-27 19:59:57'),
(42, 27, 'ffff', '', '1769545142_DSC_8064 copy.jpg', '2026-01-27 20:19:02'),
(43, 27, 'uuuu', '', '1769545222_DSC_8064 copy.jpg', '2026-01-27 20:20:22'),
(46, 27, 'bbbb', '', '1769545393_DSC_8064 copy.jpg', '2026-01-27 20:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_categories`
--

CREATE TABLE `sub_sub_categories` (
  `id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_sub_categories`
--

INSERT INTO `sub_sub_categories` (`id`, `sub_category_id`, `name`, `description`, `created_at`) VALUES
(1, 1, 'Americano', NULL, '2025-09-08 23:03:25'),
(2, 1, 'Brewed Coffee', NULL, '2025-09-08 23:56:05'),
(3, 2, 'Brewed Tea', NULL, '2025-09-08 23:57:15'),
(4, 1, 'Cappuccino', NULL, '2025-09-08 23:57:56'),
(5, 1, 'Latte', NULL, '2025-09-08 23:58:06'),
(6, 4, 'Iced Coffee Drinks', NULL, '2025-09-09 00:36:00'),
(7, 4, 'Cold Brewed Coffee', NULL, '2025-09-09 01:01:09'),
(8, 1, 'Espresso', NULL, '2025-09-09 01:03:14'),
(47, 26, 'Iced Tea', NULL, '2025-10-01 13:04:05'),
(48, 1, 'Mocha', NULL, '2025-10-01 13:19:06'),
(49, 1, 'Other Hot Drinks', NULL, '2025-10-01 13:19:31'),
(50, 4, 'Nitro Cold Brew', NULL, '2025-10-01 13:20:21'),
(51, 4, 'Iced Latte', NULL, '2025-10-01 13:20:39'),
(52, 27, 'Fruit Smoothies', NULL, '2025-10-01 13:21:31'),
(53, 27, 'Green Smoothies', NULL, '2025-10-01 13:21:46'),
(54, 27, 'Yogurt Smoothies', NULL, '2025-10-01 13:22:05'),
(55, 27, 'Protein Smoothies', NULL, '2025-10-01 13:22:19'),
(56, 29, 'Fresh Juices', NULL, '2025-10-01 13:22:58'),
(57, 29, 'Lemonades', NULL, '2025-10-01 13:23:11'),
(58, 29, 'Infused Water', NULL, '2025-10-01 13:23:25'),
(59, 29, 'Herbal Coolers', NULL, '2025-10-01 13:23:44'),
(60, 30, 'Coffee Frappé', NULL, '2025-10-01 13:24:48'),
(61, 30, 'Chocolate Frappé', NULL, '2025-10-01 13:25:00'),
(62, 30, 'Fruit Frappé', NULL, '2025-10-01 13:25:13'),
(63, 30, 'Desert-Inspired Frappé', NULL, '2025-10-01 13:25:24'),
(64, 31, 'Water', NULL, '2025-10-01 13:26:07'),
(65, 31, 'Soft Drinks', NULL, '2025-10-01 13:26:20'),
(66, 31, 'Energy Drinks', NULL, '2025-10-01 13:26:52'),
(67, 3, 'Egg Station', NULL, '2025-10-01 13:28:30'),
(68, 3, 'Breakfast Sandwishes', NULL, '2025-10-01 13:28:44'),
(69, 3, 'Healthy Start', NULL, '2025-10-01 13:28:58'),
(70, 32, 'Sandwishes', NULL, '2025-10-01 13:29:25'),
(71, 32, 'Main Dishs', NULL, '2025-10-01 13:29:42'),
(72, 32, 'Salads', NULL, '2025-10-01 13:29:56'),
(73, 32, 'Sides', NULL, '2025-10-01 13:30:07'),
(74, 32, 'Soups', NULL, '2025-10-01 13:30:37'),
(75, 32, 'Sauces', NULL, '2025-10-01 13:30:44'),
(76, 35, 'Savory Breads', NULL, '2025-10-01 13:31:06'),
(77, 35, 'Sweet Breads', NULL, '2025-10-01 13:31:23'),
(78, 36, 'Cakes & Cheesecakes', NULL, '2025-10-01 13:31:40'),
(79, 36, 'Brownies & Bars', NULL, '2025-10-01 13:31:53'),
(80, 36, 'Pastries & Bakery Sweets', NULL, '2025-10-01 13:32:12'),
(81, 36, 'Cold Cups & Desserts', NULL, '2025-10-01 13:32:25'),
(82, 36, 'Oriental Sweets', NULL, '2025-10-01 13:32:39'),
(96, 40, 'sss', NULL, '2026-01-27 19:59:29'),
(98, 41, 'ggg', NULL, '2026-01-27 20:01:52'),
(99, 41, 'kkk', NULL, '2026-01-27 20:10:00'),
(100, 41, 'ttt', NULL, '2026-01-27 20:10:48'),
(101, 42, 'vvvv', NULL, '2026-01-27 20:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `day` int(2) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `email`, `password`, `role`, `created_at`, `day`, `month`, `year`, `gender`) VALUES
(27, 'Mohamed', 'Ayman', 'mohamedayman12oo54@gmail.com', '$2y$10$wxhrjjyHSa7mWbZck9wdD.v3hrTgbHtEgWed62V83Day9QQ0wo1.i', 'admin', '2025-10-05 14:24:37', NULL, NULL, NULL, NULL),
(28, 'Adam', 'Ayman', 'adamayman345@gmail.com', '$2y$10$O1mPRUHRNhmsVOv1IgEbqONuodrbS99MVu.kbxerPnNscsCvSYo0.', 'customer', '2025-10-05 14:41:24', 4, 9, 2013, 'male'),
(29, 'Hady', 'Saad', 'hadysaad59@gmail.com', '$2y$10$RZur.4PrTvH7sP61IA5uNOqKzAVbsZC5GxKxIaRzWenk98T.M9g0y', 'customer', '2025-10-05 19:03:11', NULL, NULL, NULL, NULL),
(30, 'Mohamed', 'Ayman Ali', 'moayman932@gmail.com', '$2y$10$FzL1PyfEw1KERUMGMRSaJeQgctk0/QMhXDj/eQ8fgE4uyB85WQkFy', 'customer', '2025-10-08 22:14:44', 29, 1, 2005, 'male'),
(31, 'Raneem', 'Ayman Ali', 'raneem44@gmail.com', '$2y$10$2gjiEcG3kIwbQJC8V3oVKuTjMJwQ6vr7czATMdnzgiX9zsFZc992m', 'customer', '2025-10-10 13:52:56', 18, 9, 2007, 'female'),
(35, 'Lionel', 'Messi', 'messi_l@gmail.com', '$2y$10$bcmt6IEUOJQZ8xf1KpC6xuLYnKkymG2xk/SOyrEkb.hdVu1Jzm7me', 'customer', '2025-10-14 22:03:49', 15, 8, 1964, 'male'),
(36, 'Zakria', '', 'zakria@gmail.com', '$2y$10$VAFP.D7upQhKnn4wdXiTOukEn5Mhkqi5DoLA7f/NIraRoUMl/faUa', 'customer', '2025-11-04 07:40:29', 10, 7, 1931, 'male'),
(37, 'Admin', 'User', 'admin@example.com', '$2y$10$QJj0z/xeq7Q1Gfj2k3J5Vur8o3WQ1eLV5J5Y3k4CkKZCny2D4nDqS', 'admin', '2025-11-04 07:58:53', 4, 11, 2025, 'male'),
(39, 'Dexter', '', 'dexter@gmail.com', '$2y$10$Sr/rthabGYhzzjxwAdLjp.YS69mfoOlUkho1RqsZ7WRQBob6StP4y', 'customer', '2025-11-26 16:45:51', 1, 1, 1925, 'male'),
(40, 'wedad', 'fawzy', 'wedad_sharaky@gmail.com', '$2y$10$ud8gRK1enExCNmyzEEAAqOWWaRJYXo7jW1S4TR5sOnV3a2YrgKcci', 'admin', '2025-12-13 03:56:19', NULL, NULL, NULL, NULL),
(41, 'hayam', '', 'hayam_sharaky@gmail.com', '$2y$10$JN14qokPH6i16MS8fjuvqewkQz/7A.EiXzILfJE0ewRfj4QqOgtne', 'customer', '2025-12-13 04:03:18', NULL, NULL, NULL, NULL),
(42, 'fawzy', 'mahmoud', 'fawzy@gmail.com', '$2y$10$d5atCU6afec.Qfh2PDcHBOeVHi9m7wEND/QqdrGeP0eyNxozvnUyG', 'customer', '2025-12-15 04:21:11', 16, 8, 1959, 'male'),
(43, 'samer', 'Ahmed', 'samer@gmail.com', '$2y$10$3Ly4kT26zVguLcMgBP7jGui5JjR1EDgQY/qKmGfg0bHd6lfZYIuuq', 'employee', '2025-12-29 00:46:07', NULL, NULL, NULL, NULL),
(59, 'Lionel', 'Messi', 'messi_lionel@gmail.com', '$2y$10$l2Jvu0wi/V/icPbBEqoZF.nwjDTsCnvQqwajWMnhZQNYtXWV64qS6', 'admin', '2026-01-24 22:10:23', NULL, NULL, NULL, NULL),
(60, 'kareem', '', 'kareem@gmail.com', '$2y$10$lGZ2R1bdslEqDoF6k5VmQ.rFTIZ6yYIUJqP/yhx.90rJjBgOyXRGq', 'customer', '2026-01-25 11:14:16', NULL, NULL, NULL, NULL),
(87, 'gygy', '', 'gygy@gmail.com', '$2y$10$RFBow0ILqsQ3P80/J0FqQO2PvGylNjdEmR/bSheDdHLEJm8SIZwQC', 'employee', '2026-01-27 12:56:18', NULL, NULL, NULL, NULL),
(89, 'kyky_', '', 'kyky@gmail.com', '$2y$10$BqrNSzKe1AJWNmYZP0g5c.wuwXhrNQZdRyC12cLWjDgDfAkVwCgqW', 'employee', '2026-01-27 12:59:54', NULL, NULL, NULL, NULL),
(90, 'nono', '', 'nono@gmail.com', '$2y$10$U.tocT9r48Fmd4iNQrvbJu9pSGTnWdSnn0MB75YOn38sO3eNbl2kS', 'employee', '2026-01-27 13:07:15', NULL, NULL, NULL, NULL),
(91, 'yoyo', '', 'yoyo@gmail.com', '$2y$10$9c7uh.2cXgakpIjU0cUOhO0Rj7vsJtUWvQlQ9RyQQ/lVVipJ24KUu', 'employee', '2026-01-27 13:09:58', NULL, NULL, NULL, NULL),
(92, 'roro', '', 'roro@gmail.com', '$2y$10$Eby5RdWIbY3gLyOuxOKLIO4a4krSMS0Fai9fm6SSUDMIOETCe1a46', 'employee', '2026-01-27 13:16:42', NULL, NULL, NULL, NULL),
(93, 'wewe', '', 'wewe@gmail.com', '$2y$10$1.GiTcLa4zlXWFX17cLLneWZpgAlNN97GqPtKViREW8lq63x6EClq', 'employee', '2026-01-27 13:23:12', NULL, NULL, NULL, NULL),
(94, 'qeqe___', '', 'qeqe@gmail.com', '$2y$10$7aSnbPMmDpp6D6BwahCPxu1lCdg9KE8Bsw3Vq6QvBuql4aWh5Hxie', 'employee', '2026-01-27 13:28:19', NULL, NULL, NULL, NULL),
(100, 'sasa', 'mohamed', 'sasa@gmail.com', '$2y$10$T9BtSATaQJkcAEgwuToPuu2R1Yi4Yj015XMjiTXXAXEFVMkYQMnHS', 'employee', '2026-01-27 14:07:03', NULL, NULL, NULL, NULL),
(101, 'doda', 'ayman_', 'doda@gmail.com', '$2y$10$wggZpNsSERxmieimgpwMK.MWg3MmGkLDADu.TWyeEfXH2hbdjM9Xe', 'employee', '2026-01-27 14:08:07', NULL, NULL, NULL, NULL),
(102, 'sara', 'wael', 'sara@gmail.com', '$2y$10$qcgCoHAerNog6LJebuNaBuR7NUIl.3QJDF7m5LhAxYr7KZy24zr8y', 'customer', '2026-01-27 14:37:39', NULL, NULL, NULL, NULL),
(105, 'veve', '', 'veve@gmail.com', '$2y$10$EfWO7sFFJ8TLLdiulzoMXuDD4GSkHNA/JX4Qj8gEybxtxg/pvwJ.C', 'customer', '2026-01-27 14:47:54', NULL, NULL, NULL, NULL),
(107, 'Eden', 'Madden', 'sebyxory@mailinator.com', '$2y$10$nLILpgDJI.Fyrx1m/8gFQ.TeRJXiHUArAbBKMKWNhmHnxqLboio4e', 'employee', '2026-01-28 10:55:15', NULL, NULL, NULL, NULL),
(108, 'Soso', 'Ahmed', 'soso_ahmed@gmail.com', '$2y$10$MMr3RpyH1YlD6ID.pEtpBeeuS1DFy3oAzblZu9EVYmKVY9GCa7CLC', 'customer', '2026-01-29 13:50:24', NULL, NULL, NULL, NULL),
(109, 'dodo_gihan', '', 'dodo@gmail.com', '$2y$10$gYvvPuuIPCnlLQCFpdPu2ORvxn1O9FQd4r4ZkviAv6RtElcxWl6He', 'customer', '2026-01-29 13:51:44', NULL, NULL, NULL, NULL),
(110, 'somia', 'samy', 'somia@gmail.com', '$2y$10$svy6DMCwgNpnn7Kgu/BW0..05D6f9/f9EGMFbL/Ylgu1fauzVA46a', 'customer', '2026-01-29 13:56:18', NULL, NULL, NULL, NULL),
(111, 'Ahmed', 'Hamdy', 'ahmed_hamdy@gmail.com', '$2y$10$G5qL97GcHiHLvEZV1OeWYOpblbGbzROMdSVRfyycaPTc.I4o.D8nq', 'customer', '2026-01-29 14:09:56', 14, 7, 1939, 'male'),
(113, 'Jana', 'Garcia', 'duba@mailinator.com', '$2y$10$Vg6jjSsRTkOTkOC9uFLUZOQH4S33FNnsmIAnyGPt5H./YGMzKm/8S', 'customer', '2026-01-29 14:12:10', NULL, NULL, NULL, NULL),
(114, 'Lana', 'El-kholy', 'lana@gmail.com', '$2y$10$xdso1yZ4D1Pogoj6S5LXJONbpo9HHcGYTMWgyJ2lJPIdY7hkD2n2C', 'customer', '2026-01-29 15:17:16', NULL, NULL, NULL, NULL),
(115, 'karim', '', 'karim@gmail.com', '$2y$10$oZHnZKdE7fOQcqXNGoUIxuNhT1eq7fUx7UqiNfTzONkyuB750TD4.', 'customer', '2026-01-29 15:19:56', NULL, NULL, NULL, NULL),
(116, 'vini', 'jr', 'vini@gmail.com', '$2y$10$/y5/NMbjchbbfMbeE/q6VOtx6qs8l2lESBNRarD6tW6WzFfIyu8lC', 'customer', '2026-01-29 15:23:25', NULL, NULL, NULL, NULL),
(117, 'de', 'jong', 'de@gmail.com', '$2y$10$17wdOahRUzjH7UGkxf6Kf.BxoLpzoitadF3gobyzkXjZRQ67P94IK', 'customer', '2026-01-29 15:56:35', NULL, NULL, NULL, NULL),
(118, 'pernal', '', 'pernal@gmail.com', '$2y$10$ZSKt6sXEARZpiZxquiQQgO8I.HkKtGjB8BxGTM2Rt2stM.2FYjG2W', 'customer', '2026-01-29 16:03:27', NULL, NULL, NULL, NULL),
(119, 'Alyssa', 'Copeland', 'nemybumo@mailinator.com', '$2y$10$vniW4jiimb8pU1zThHpwoe4FWc3bMon3DoGcDMqgz9GFpEzqcZ9gS', 'customer', '2026-01-29 16:14:29', NULL, NULL, NULL, NULL),
(120, 'Gisela', 'Osborn', 'pasa@mailinator.com', '$2y$10$Wz7jQ8ICVR5CwizCccubyePMVxsaBeiQecZZM/184n3PFPoBzYDZG', 'customer', '2026-01-29 16:14:49', NULL, NULL, NULL, NULL),
(122, 'Garcia', '', 'garcia@gmail.com', '$2y$10$6fwjoOeqZfkHYevDD2BJceYp2kaQjPj1Tpk72pBv0HoTLqo1mIB/S', 'customer', '2026-01-29 22:59:10', NULL, NULL, NULL, NULL),
(123, 'Ronan', 'Lambert', 'falit@mailinator.com', '$2y$10$twjKKOhEFQ98iFhk1IRA1e27VAosSgiggN3MtNAxbgkRMJrSsnqtm', 'customer', '2026-01-29 23:24:36', NULL, NULL, NULL, NULL),
(124, 'Megan', 'Flores', 'matabe@mailinator.com', '$2y$10$JEOgBm4XleeJMO0CAJukcekeuLQ.mVNpcOh7oXwBTDKyTJFJB5/s6', 'customer', '2026-01-30 17:26:06', NULL, NULL, NULL, NULL),
(125, 'Zeus', 'Mclean', 'qovad@mailinator.com', '$2y$10$Lu/ZslmFzotiWSzck7V/1.kl1MZM4/P.pE5FrkjWhFNpZ.A.sKK2K', 'customer', '2026-01-30 21:48:12', NULL, NULL, NULL, NULL),
(126, 'Gajjjjj', '', 'bahy@mailinator.com', '$2y$10$UI49NwT3plcuyhOFOqwdh.lwljxldrOsEvTWVhmYsEiD3khsfEG4K', 'customer', '2026-02-01 10:56:14', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_phones`
--

CREATE TABLE `user_phones` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_phones`
--

INSERT INTO `user_phones` (`id`, `user_id`, `phone`, `is_primary`, `created_at`) VALUES
(1, 28, '01034899610', 0, '2025-10-08 16:21:33'),
(2, 30, '01034509789', 0, '2025-10-08 22:15:44'),
(3, 31, '01034378944', 0, '2025-10-10 13:53:53'),
(7, 35, '0102365214444', 0, '2025-10-14 22:04:21'),
(8, 36, '01067773139', 0, '2025-11-04 07:41:29'),
(9, 39, '01020168514', 0, '2025-11-26 16:46:30'),
(10, 42, '01553053728', 0, '2025-12-16 04:43:37'),
(11, 111, '010245031', 0, '2026-01-29 14:10:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`product_id`,`size`),
  ADD KEY `cart_ibfk_2` (`product_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `delivery_user_id` (`delivery_user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_sub_category_id` (`sub_sub_category_id`,`name`);

--
-- Indexes for table `menu_item_size_price`
--
ALTER TABLE `menu_item_size_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_category_id` (`main_category_id`,`name`);

--
-- Indexes for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_category_id` (`sub_category_id`,`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_phones`
--
ALTER TABLE `user_phones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `menu_item_size_price`
--
ALTER TABLE `menu_item_size_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_details`
--
ALTER TABLE `staff_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `user_phones`
--
ALTER TABLE `user_phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`delivery_user_id`) REFERENCES `staff_details` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`sub_sub_category_id`) REFERENCES `sub_sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_item_size_price`
--
ALTER TABLE `menu_item_size_price`
  ADD CONSTRAINT `menu_item_size_price_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD CONSTRAINT `staff_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`main_category_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD CONSTRAINT `sub_sub_categories_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_phones`
--
ALTER TABLE `user_phones`
  ADD CONSTRAINT `user_phones_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
