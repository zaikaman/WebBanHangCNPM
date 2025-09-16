-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 05:48 AM
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
-- Database: `webbanhang_cnpm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_ad` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_ad`, `user_name`, `password`, `admin_status`) VALUES
(4, 'admin', '202cb962ac59075b964b07152d234b70', 1),
(15, 'admin2', 'ce9642a7df00bb973f5d9c55d5f67c49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_baiviet`
--

CREATE TABLE `tbl_baiviet` (
  `id` int(11) NOT NULL,
  `tenbaiviet` varchar(255) NOT NULL,
  `tomtat` text DEFAULT NULL,
  `noidung` longtext DEFAULT NULL,
  `id_danhmuc` int(11) NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_baiviet`
--

INSERT INTO `tbl_baiviet` (`id`, `tenbaiviet`, `tomtat`, `noidung`, `id_danhmuc`, `tinhtrang`, `hinhanh`, `link`) VALUES
(2, 'MU chậm sa thải Ten Hag', 'Summary for MU chậm sa thải Ten Hag', 'Content for MU chậm sa thải Ten Hag', 14, 1, 'tin1.jpg', 'https://www.24h.com.vn/bong-da/nong-bang-xep-hang-ngoai-hang-anh-mu-te-nhat-lich-su-chelsea-lung-lay-top-4-c48a1608578.html'),
(3, 'BXH Ngoại hạng Anh: MU tệ nhất lịch sử, Chelsea lung lay top 4', 'Summary for BXH Ngoại hạng Anh', 'Content for BXH Ngoại hạng Anh', 14, 1, 'tin2.jpg', 'https://www.24h.com.vn/bong-da/ten-hag-biet-cui-dau-ai-da-cuu-thay-tam-song-sot-qua-giong-bao-c48a1608663.html'),
(4, 'Ten Hag cúi đầu: Ai đã cứu thầy tạm sống sót?', 'Summary for Ten Hag cúi đầu', 'Content for Ten Hag cúi đầu', 14, 1, 'tin3.jpg', 'https://www.24h.com.vn/bong-da/lewandowski-ghi-3-ban-dinh-cao-bat-kip-haaland-dua-chiec-giay-vang-c48a1608595.html'),
(5, 'Lewandowski ghi 3 bàn đỉnh cao, bắt kịp Haaland đua Chiếc Giày Vàng', 'Summary for Lewandowski', 'Content for Lewandowski', 14, 1, 'tin4.jpg', 'https://www.24h.com.vn/bong-da/xau-ho-dan-sao-mu-thua-ong-gia-36-tuoi-rashford-bi-nghi-noi-xau-ten-hag-c48a1608619.html'),
(6, 'Xấu hổ: Dàn sao MU thua ông già 36 tuổi, Rashford bị nghi nói xấu Ten Hag', 'Summary for MU thua ông già 36 tuổi', 'Content for MU thua ông già 36 tuổi', 14, 1, 'tin5.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-brighton-tottenham-hang-cong-thang-hoa-ngoai-hang-anh-c48a1608573.html'),
(8, 'Video bóng đá: Brighton - Tottenham, hàng công thăng hoa', 'Summary for Brighton vs Tottenham', 'Content for Brighton vs Tottenham', 14, 1, 'tin7.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-sociedad-atletico-alvarez-ghi-ban-giay-51-la-liga-c48a1608577.html'),
(9, 'Video futsal: Brazil - Argentina, đăng quang kịch tính chung kết Futsal World Cup', 'Summary for Brazil vs Argentina Futsal', 'Content for Brazil vs Argentina Futsal', 14, 1, 'tin8.jpg', 'https://www.24h.com.vn/bong-da/video-futsal-brazil-argentina-dang-quang-kich-tinh-chung-ket-futsal-world-cup-c48a1608596.html'),
(10, 'Video bóng đá: Sociedad - Atletico, Alvarez ghi bàn giây 51', 'Summary for Sociedad vs Atletico', 'Content for Sociedad vs Atletico', 14, 1, 'tin9.jpg', 'https://www.24h.com.vn/bong-da/video-bong-da-sociedad-atletico-alvarez-ghi-ban-giay-51-la-liga-c48a1608577.html'),
(14, 'Vì sao Mavericks không nên chiêu mộ John Collins về thi đấu cùng Luka Doncic và Kyrie Irving', 'Dallas Mavericks khởi đầu mùa giải năm nay không thật sự tốt khi thắng 9, thua 7 sau 16 trận đầu tiên. Đội bóng của huấn luyện viên Jason Kidd có thể phải tính đến phương án chiêu mộ những cầu thủ mới nhằm cải thiện tình hình cũng như cố gắng trở lại với cuộc đua vô địch. \\\\r\\\\n\\\\r\\\\nTuy nhiên, trong khi có rất nhiều cái tên được Mavericks xem xét, tờ Fadeaway World cho rằng nhà đương kim vô địch miền Tây nên bỏ qua tiền phong chính John Collins của Utah Jazz dù đây là một cầu thủ sở hữu phong độ rất tốt. Lý do là gì?', 'Ở mùa giải NBA năm nay, John Collins có trung bình 17,6 điểm (tỷ lệ ghi điểm 53,1%), 8,3 rebounds và 2,6 kiến tạo mỗi trận cho Utah Jazz. Tính hiệu quả và khả năng hút đối thủ, tạo không gian cho đồng đội tấn công của Collins sẽ biến anh trở thành một tài sản quý giá cho bất kỳ đội bóng nào. Tuy nhiên, thực tế vị trí tiền phong chính lúc này của Mavericks không tệ đến mức phải thay đổi ngay lập tức.\\\\r\\\\n\\\\r\\\\nMavericks hiện đã có P.J. Washington đảm nhiệm vai trò tiền phong chính. Có thể Washington không được đánh giá cao bằng Collins nhưng anh vẫn thể hiện tương đối ổn. Trong khi đó, nếu muốn đưa John Collins về sân American Airlines Center, đội bóng thuộc bang Texas sẽ phải chi một khoản rất lớn.', 9, 1, 'bb1.jpg', 'https://www.sportingnews.com/vn/nba/news/mavs-advised-against-pairing-125-million-forward-luka-doncic-kyrie-irving/855a3939c3e9389ae480564f'),
(15, 'Vì sao Golden State Warriors nên chuyển nhượng Jonathan Kuminga ngay khi có thể', 'Từng được đánh giá là món hời với Golden State Warriors khi gia nhập đội bóng ở lượt chọn thứ 7 tại NBA Draft 2021, Kuminga giờ đây đang dần trở nên thừa thãi trong đội hình đội bóng vùng vịnh.\\r\\n\\r\\nMùa giải trước, Kuminga thừa nhận anh \\\"mất niềm tin\\\" vào huấn luyện viên Steve Kerr. Tuy nhiên cả 2 sau đó đã ngồi xuống nói chuyện, và Kuminga đã có điều mình muốn. Anh được chơi nhiều hơn và phần nào gây ấn tượng trong giai đoạn cuối mùa giải trước.\\r\\n\\r\\nMặc dù ghi trung bình gần 20 điểm mỗi trận sau cuộc gặp gỡ vào đầu tháng 1, Warriors và Kuminga vẫn chưa tìm được tiếng nói chung trong việc gia hạn hợp đồng. Một tháng sau mùa giải 2024/25, Warriors hiện đang dẫn đầu miền Tây. Tuy nhiên \\\"Các chiến binh\\\" làm điều đó với sự đóng góp rất hạn chế từ Kuminga.\\r\\n\\r\\nKuminga mất vị trí trong đội hình xuất phát chỉ sau 4 trận. Anh chơi trung bình dưới 20 phút trong 3 trận gần nhất. Với sự trở lại mạnh mẽ của của Andrew Wiggins và Draymond Green, Kuminga trở nên lạc lõng tại Chase Center.\\r\\n\\r\\nKuminga chắc chắn có tài năng — anh đã thể hiện điều đó suốt 4 năm qua — nhưng anh tỏ ra không phù hợp với hệ thống mà Kerr xây dựng. Do đó một trao đổi sẽ tốt cho cả Kuminga và Warriors.', 'Hàng công của Warriors vẫn xoay quanh Stephen Curry, hiện đã 36 tuổi. Steve Kerr và các cộng sự biết chính xác đội bóng cần những kiểu cầu thủ nào cần thiết để giúp Curry tỏa sáng. Và trong số đó, không có mẫu cầu thủ như Kuminga.\\r\\n\\r\\nCurry là một trong những cầu thủ ném bóng nguy hiểm nhất NBA và là người tận dụng \\\"screen\\\" cực kỳ xuất sắc. Để phát huy Curry ở mức tối đa, Warriors cần những cầu thủ có khả năng \\\"screen\\\" tốt và tư duy chuyền bóng nhạy bén. Nhưng các điều trên đều không phải điểm mạnh của Kuminga.\\r\\n\\r\\nKuminga thậm chí không phải tay ném tốt, tỷ lệ ném 3 điểm của anh chỉ đạt 33,9% trong sự nghiệp. Thậm chí mùa này, con số đó còn tệ hơn, chỉ ở mức 31,9%. Khi Kuminga trên sân, anh không tạo ra mối nguy đủ lớn với đối thủ, từ đó làm bó hẹp không gian chơi bóng của Curry.\\r\\n\\r\\nĐiều đó không có nghĩa là Kuminga là một cầu thủ tấn công tệ. Ngược lại, anh ấy là một mối đe dọa lớn ở khu vực bảng rổ nhờ lối chơi thể chất và mạnh mẽ của mình. Các đối thủ khó lòng ngăn cản các pha bóng đột phá dũng mãnh của Kuminga. Nhưng vấn đề là phong cách đó không phù hợp với hệ thống xoay quanh Curry.', 9, 1, 'bb2.jpeg', 'https://www.sportingnews.com/vn/nba/news/why-should-golden-state-warriors-trade-jonathan-kuminga/69eb0d4d111021ca6bafa774'),
(16, 'Thể thức thi đấu NBA Cup 2024', 'Năm 2023 là đầu tiên trong lịch sử, NBA giới thiệu một giải đấu giữa mùa giải, được gọi là In-Season Tournament.\\\\\\\\r\\\\\\r\\n\\\\\\\\r\\\\\\r\\nGiải đấu này được lập ra nhằm tăng tính giải trí của NBA, mang đến những trải nghiệm tốt hơn dành cho người hâm mộ. Giải đấu này bao gồm cả 30 đội bóng đều được tham dự và có cả chức vô địch cho tập thể thi đấu tốt nhất.\\\\\\\\r\\\\\\r\\n\\\\\\\\r\\\\\\r\\nĐến năm 2024, giải đấu được đổi tên thành NBA Cup nhưng vẫn giữ nguyên thể thức.', 'Dưới đây là những điều cần biết về thể thức thi đấu In-Season Tournament\\\\\\\\r\\\\\\r\\n\\\\\\\\r\\\\\\r\\nIn-Season Tournament sẽ bao gồm 2 giai đoạn: vòng bảng và vòng loại trực tiếp.\\\\\\\\r\\\\\\r\\nCả 30 đội bóng sẽ chia làm 6 bảng theo thể thức bốc thăm theo miền, mỗi bảng có 5 đội và mỗi đội thi đấu 4 trận.\\\\\\\\r\\\\\\r\\n6 đội bóng đứng đầu mỗi bảng sẽ lọt vào vòng loại trực tiếp. Hai đội bóng nhì bảng có thành tích tốt nhất cũng sẽ lọt vào vòng loại trực tiếp (mỗi miền có 1 đội).\\\\\\\\r\\\\\\r\\nCác trận đấu ở vòng loại trực tiếp diễn ra theo thể thức Best of 1.\\\\\\\\r\\\\\\r\\nTrận bán kết và chung kết sẽ diễn ra ở sân trung lập. Các trận đấu ở In-Season Tournament (trừ trận chung kết) sẽ được tính là một trận đấu xếp hạng tại Regular Season.', 9, 1, 'bb3.jpg', 'https://www.sportingnews.com/vn/nba/news/nba-season-tournament-bang-thi-dau/pgkirlb4jilhn9vtrljdfm68'),
(17, 'Damian Lillard sẽ đến đội bóng nào nếu rời khỏi Milwaukee Bucks', 'Tham vọng vô địch của Bucks bị ảnh hưởng nghiêm trọng bởi khởi đầu tệ hại đầu mùa giải 2024/25 và chắc chắn họ muốn thay đổi. \\\\r\\r\\n\\\\r\\r\\nNhiều tin đồn cho rằng, Giannis Antetokounmpo đang có ý định gia nhập một đội bóng sở hữu tiềm lực và tham vọng hơn để cạnh tranh chức vô địch. Nếu để Á Thần Hy Lạp ra đi, họ sẽ phải tái xây dựng hoàn toàn, bởi Giannis luôn là gương mặt, là biểu tượng của đội bóng này trong nhiều năm qua.\\\\r\\r\\n\\\\r\\r\\nĐối với Milwaukee Bucks lúc này, có một phương án dễ thực hiện hơn, đó là đẩy Damian Lillard sang đội khác. Động thái này vừa có thể giữ chân Giannis, vừa giúp ngôi sao người Hy Lạp được hỗ trợ tốt hơn khi Damian Lillard đang dần cảm thấy gánh nặng của tuổi tác.\\\\r\\r\\n\\\\r\\r\\nDẫu vậy, việc Damian Lillard sở hữu mức lương lớn sẽ là trở ngại cho Bucks, bởi không có đội bóng nào muốn trả con số 63 triệu USD cho một cầu thủ sẽ bước sang tuổi 36 trong mùa giải 2026/27 - năm cuối cùng trong hợp đồng của Damian Lillard.\\\\r\\r\\n\\\\r\\r\\nTuy nhiên, khả năng tấn công của Damian Lillard vẫn luôn là thứ vũ khí có giá trị, và nếu khéo léo trên bàn đàm phán, nhiều khả năng Milwaukee Bucks sẽ có thể thuyết phục được các đối tác.', 'Đầu tiên, cần phải làm rõ rằng mức lương khổng lồ của Damian Lillard sẽ không phù hợp với các đội bóng vượt quỹ lương, bao gồm Phoenix Suns, Denver Nuggets, New York Knicks, Philadelphia 76ers, Los Angeles Clippers hay Los Angeles Lakers. Những đội bóng đang ổn định với bộ khung hiện có như Minnesota Timberwolves hay Boston Celtics sẽ không bao giờ ngồi vào bàn đàm phán với Bucks để đưa về Damian Lillard.', 9, 1, 'bb4.jpeg', 'https://www.sportingnews.com/vn/nba/news/damian-lillard-trade-destinations-bucks/056bf21dbae210fbb0254b67'),
(18, 'Tiểu sử gia đình Klay Thompson', 'Klay Thompson sinh ra trong một gia đình gồm toàn những vận động viên từ nhiều môn thể thao khác nhau.\\r\\n\\r\\nCựu sao Warriors từng 4 lần vô địch NBA, và gia đình đóng vai trò cực kỳ quan trọng trong sự nghiệp thể thể thao của anh. Phát biểu sau chức vô địch 2015, Thompson từng nói về các anh em của mình: \\\"Không có họ, không chơi bóng với họ hàng ngày, tôi không thể trở thành cầu thủ như hiện tại\\\".\\r\\n\\r\\nCả gia đình anh, bao gồm bố mẹ và các anh em trai đều chơi thể thao ở nhiều mức độ khác nhau, trong đó có những người giành được thành công rất ấn tượng. \\r\\n\\r\\nHãy cùng Sporting News tìm hiểu về gia đình của Klay Thompson.', 'Cha của Klay Thompson: Mychal Thompson\\r\\nMẹ của Klay Thompson: Julie Thompson\\r\\nAnh trai của Klay Thompson: Mychel Thompson\\r\\nEm trai Klay Thompson: Trayce Thompson', 9, 1, 'bb5.jpeg', 'https://www.sportingnews.com/vn/nba/news/gia-%C4%91inh-van-dong-vien-the-thao-ngoi-sao-nba-klay-thompson/ccvco5qfbzb0bqvbgzvacbbw'),
(19, 'Nguồn gốc tên gọi của đội bóng rổ NBA Denver Nuggets', 'Trong nhiều năm qua, Denver Nuggets đã trở thành 1 thế lực tại NBA. Họ sở hữu một trong những trung phong vĩ đại nhất trong lịch sử là Nikola Jokic, cùng đỉnh cao là chức vô địch NBA năm 2023.\\r\\n\\r\\nVậy tại sao đội bóng này lại có tên là Denver Nuggets? The Sporting News sẽ cung cấp câu trả lời trong bài viết dưới đây.', 'Denver Nuggets được thành lập vào năm 1967, với cái tên ban đầu là Denver Rockets. Kể từ năm 1967 đến năm 1976, họ thi đấu tại ABA, giải đấu bóng rổ lớn tại Mỹ và có vị thế thua kém NBA một chút.\\r\\n\\r\\nVì sự phát triển chung của môn thể thao này tại Mỹ, ban tổ chức của đôi bên đã quyết định gộp 2 giải đấu này lại với tên gọi chính thức là NBA. Đội bóng Denver khi đó đang thi đấu tại ABA, cũng chính thức góp mặt trong mái nhà mới mang tên NBA.\\r\\n\\r\\nVấn đề phát sinh từ đây, khi NBA lúc đó đã có một đội bóng mang tên Rockets, đó là San Diego Rockets (tiền thân của Houston Rockets ngày nay). Do đó, ban lãnh đạo đội bóng Denver đã quyết định sử dụng cái tên khác để tránh trùng lặp, cũng như phù hợp hơn với bản sắc và văn hóa của đội bóng.', 9, 1, 'bb6.jpg', 'https://www.sportingnews.com/vn/nba/news/denver-nuggets-team-name-origin/33103c7ee1da272e8340c50f');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_history`
--

CREATE TABLE `tbl_chat_history` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chat_history`
--

INSERT INTO `tbl_chat_history` (`id`, `email`, `session_id`, `message`, `response`, `created_at`) VALUES
(2, NULL, NULL, 'chào bạn, email của tôi là gì', 'Xin chào bạn, email của chúng tôi là support@7tcc.vn. Bạn có cần hỗ trợ gì thêm không ạ?', '2024-11-11 12:16:08'),
(3, 'thinhgpt1706@gmail.com', NULL, 'chào bạn, email của tài khoản tôi là gì', 'Chào bạn, thông tin tài khoản cá nhân của bạn sẽ được bảo mật. Bạn vui lòng liên hệ trực tiếp qua hotline 0938688079 để chúng tôi hỗ trợ bạn kiểm tra và cung cấp thông tin chính xác nhất nhé.', '2024-11-11 12:17:03'),
(4, 'thinhgpt1706@gmail.com', NULL, 'tin nhắn trước đó của tôi là gì', 'Chào bạn, bạn vừa gửi tin nhắn hỏi thông tin email của tài khoản. Tôi đã trả lời bạn rằng thông tin tài khoản cá nhân sẽ được bảo mật và hướng dẫn bạn liên hệ trực tiếp qua hotline để được hỗ trợ kiểm tra và cung cấp thông tin chính xác nhất.', '2024-11-11 12:17:36'),
(5, NULL, NULL, 'có áo đá banh đội MU không', 'Chào bạn, hiện tại cửa hàng chúng tôi có áo đá banh của đội MU. Bạn muốn mình tư vấn thêm về sản phẩm này không ạ?', '2024-11-11 12:19:10'),
(6, NULL, NULL, 'có', 'Chào bạn, chúng tôi có rất nhiều mẫu áo đá banh của đội MU. Bạn có muốn mình tư vấn chi tiết hơn về các mẫu áo này không ạ?', '2024-11-11 12:19:22'),
(7, 'thinhgpt1706@gmail.com', NULL, 'web 7tcc có bao nhiêu sản phẩm vậy', 'Hiện tại, trên website của 7TCC chúng mình đang có tổng cộng **20 sản phẩm** thuộc các danh mục: Bóng đá, Cầu lông và Bóng rổ. Bạn có thể truy cập website của chúng mình tại địa chỉ https://7tcc.vn/ để tham khảo chi tiết từng sản phẩm nhé!', '2024-11-11 12:19:41'),
(8, NULL, NULL, 'giới thiệu cho tôi 1 mẫu', 'Chào bạn, mẫu áo đấu sân khách của Manchester United mùa giải 2023-2024 là một lựa chọn tuyệt vời dành cho bạn. Áo có màu trắng chủ đạo, được thiết kế với họa tiết độc đáo lấy cảm hứng từ những năm 1990. Mẫu áo này được làm từ chất liệu vải cao cấp, thoáng khí, thấm hút mồ hôi tốt, giúp bạn luôn cảm thấy thoải mái khi mặc.', '2024-11-11 12:19:41'),
(9, 'thinhgpt1706@gmail.com', NULL, 'sản phẩm tên là \"Áo bóng rổ 5\" có số lượng còn lại là bao nhiêu', 'Chào bạn, hiện tại chúng mình không có sản phẩm nào có tên là \"Áo bóng rổ 5\". Bạn vui lòng cung cấp lại tên chính xác của sản phẩm hoặc truy cập website của chúng mình tại https://7tcc.vn/ để kiểm tra tình trạng còn hàng của các sản phẩm nhé!', '2024-11-11 12:20:03'),
(10, 'thinhgpt1706@gmail.com', NULL, 'Có mà, mã sản phẩm là br5 đó', 'Chào bạn, cảm ơn bạn đã phản hồi.\n\nChúng mình xác nhận hiện tại sản phẩm **Áo bóng rổ BR5** còn **hết hàng**. Bạn vui lòng tham khảo những mẫu áo bóng rổ khác tại website của chúng mình nhé: https://7tcc.vn/collections/ao-bong-ro\n\nHoặc nếu bạn có nhu cầu tư vấn chi tiết hơn, bạn có thể liên hệ trực tiếp qua hotline **0938688079** để được hỗ trợ nhanh chóng nhất.', '2024-11-11 12:20:27'),
(11, NULL, NULL, 'giới thiệu áo MU', 'Chào bạn, hiện tại chúng mình có rất nhiều mẫu áo câu lạc bộ Manchester United. Bạn muốn mình tư vấn cho bạn một mẫu cụ thể nào không ạ? Hoặc bạn có thể tham khảo các mẫu áo đấu MU mới nhất tại đây: https://7tcc.vn/collections/manchester-united', '2024-11-11 12:20:47'),
(12, NULL, NULL, 'có các danh mục sản phẩm nào', 'Chào bạn, hiện tại 7TCC chúng mình đang có những danh mục sản phẩm chính sau:\n\n- Bóng đá\n- Cầu lông\n- Bóng rổ\n\nNgoài ra, chúng mình còn có các phụ kiện thể thao như: Balo, túi xách, giày thể thao, tất, băng đầu gối,...\n\nBạn có nhu cầu tìm hiểu sản phẩm ở danh mục nào ạ?', '2024-11-11 12:21:16'),
(13, NULL, NULL, 'chào bạn', 'Chào bạn, mình là trợ lý ảo của 7TCC đây. Bạn muốn mình tư vấn về sản phẩm nào ạ?', '2024-11-11 12:28:18'),
(14, NULL, NULL, 'Áo bóng rổ 5 còn hàng ko', 'Chào bạn, sản phẩm **Áo bóng rổ BR5** hiện tại **hết hàng**. Bạn vui lòng tham khảo những mẫu áo bóng rổ khác tại website của chúng mình nhé: https://7tcc.vn/collections/ao-bong-ro\n\nHoặc nếu bạn có nhu cầu tư vấn chi tiết hơn, bạn có thể liên hệ trực tiếp qua hotline **0938688079** để được hỗ trợ nhanh chóng nhất.', '2024-11-11 12:28:29'),
(15, NULL, NULL, 'store này có tổng cộng bao nhiêu áo', 'Chào bạn, tổng cộng cửa hàng 7TCC có **32** mẫu áo đấu của các bộ môn:\n\n- Bóng đá: **9** mẫu (bao gồm áo MC, áo MU)\n- Cầu lông: **6** mẫu (bao gồm áo Yonex)\n- Bóng rổ: **17** mẫu (bao gồm áo bóng rổ BR5)\n\nNgoài ra, 7TCC còn có rất nhiều mẫu phụ kiện thể thao, bạn có nhu cầu tham khảo thêm không ạ?', '2024-11-11 12:29:37'),
(16, NULL, NULL, '32 mẫu hả, trên web tôi thấy có 17 mà', 'Chào bạn, bạn có thể đang nhầm lẫn với số lượng sản phẩm trên website hiện tại của 7TCC. Trên website chỉ hiển thị một số mẫu áo bán chạy nhất và những mẫu áo mới nhất.\n\nTổng cộng cửa hàng 7TCC chúng mình có 32 mẫu áo đấu của các bộ môn thể thao chính, bao gồm:\n\n- Bóng đá: 9 mẫu\n- Cầu lông: 6 mẫu\n- Bóng rổ: 17 mẫu\n\nNgoài ra, 7TCC còn có rất nhiều mẫu phụ kiện thể thao, bạn có nhu cầu tham khảo thêm không ạ?', '2024-11-11 12:30:01'),
(17, NULL, NULL, 'kể tên các loại áo bóng đá', 'Chào bạn, hiện tại 7TCC chúng mình có những mẫu áo bóng đá như sau:\n\n- Áo MC (Mã SP: 5)\n- Áo MU (Mã SP: mu023)\n\nBạn có nhu cầu tìm hiểu chi tiết về sản phẩm nào trong số này không ạ?', '2024-11-11 12:30:16'),
(18, NULL, NULL, 'bạn biết sản phẩm tên là Áo MU ko', 'Chào bạn, sản phẩm **Áo MU** (Mã SP: mu023) hiện tại còn **99** mẫu tại cửa hàng.\n\nGiá của sản phẩm là **400.000đ**.\n\nĐây là mẫu áo bóng đá thiết kế theo chuẩn áo thi đấu của câu lạc bộ Manchester United, với chất liệu vải thoáng mát, thấm hút mồ hôi tốt, đảm bảo sự thoải mái khi vận động.\n\nBạn có nhu cầu tìm hiểu thêm thông tin về sản phẩm hoặc đặt mua sản phẩm này không ạ?', '2024-11-11 12:31:20'),
(19, NULL, NULL, 'Mã sản phẩm br5 là sản phẩm gì', 'Chào bạn, sản phẩm mã **BR5** có tên là **Áo bóng rổ 5**. \n\nSản phẩm hiện tại **hết hàng**. \n\nĐây là mẫu áo bóng rổ với thiết kế mạnh mẽ, thể thao, sử dụng chất liệu vải cao cấp, thoáng mát, thấm hút mồ hôi tốt. Bạn có thể tham khảo những mẫu áo bóng rổ khác tại website của chúng mình nhé: https://7tcc.vn/collections/ao-bong-ro.', '2024-11-11 12:33:16'),
(20, NULL, NULL, 'id danh mục', 'Chào bạn, bạn muốn biết ID danh mục của sản phẩm nào ạ?', '2024-11-11 12:33:32'),
(21, NULL, NULL, 'Áo bóng rổ 5', 'Chào bạn, sản phẩm **Áo bóng rổ 5** có ID danh mục là **1005**.\n\nBạn còn thắc mắc gì về sản phẩm này không ạ?', '2024-11-11 12:33:41'),
(22, NULL, NULL, 'Áo cầu lông 2 còn lại bao nhiêu sản phẩm', 'Chào bạn, hiện tại 7TCC chúng mình còn **100** sản phẩm **Áo cầu lông 2** (Mã SP: ynex2).\n\nBạn có nhu cầu tìm hiểu thêm thông tin về sản phẩm hoặc đặt mua sản phẩm này không ạ?', '2024-11-11 12:34:05'),
(23, NULL, NULL, 'hiện web đang có những sản phẩm nào', 'Chào bạn, hiện tại website của 7TCC chúng mình có các sản phẩm sau:\n\n**Bóng đá:**\n- Áo MC (Mã SP: 5)\n- Áo MU (Mã SP: mu023)\n\n**Cầu lông:**\n- Áo Yonex (Mã SP: ynex123)\n- Áo cầu lông 2 (Mã SP: ynex2)\n- Áo cầu lông 3 (Mã SP: ynex3)\n- Áo cầu lông 4 (Mã SP: ynex4)\n- Áo cầu lông 5 (Mã SP: ynex5)\n- Áo cầu lông 6 (Mã SP: ynex6)\n\n**Bóng rổ:**\n- Áo bóng rổ 1 (Mã SP: br1)\n- Áo bóng rổ 2 (Mã SP: br2)\n- Áo bóng rổ 3 (Mã SP: br3)\n- Áo bóng rổ 4 (Mã SP: br4)\n- Áo bóng rổ 5 (Mã SP: br5)\n\nBạn quan tâm đến sản phẩm nào ạ? Mình sẽ cung cấp thêm thông tin chi tiết cho bạn nhé!', '2024-11-11 12:35:05'),
(24, NULL, NULL, 'có những danh mục sản phẩm nào', 'Chào bạn, hiện tại 7TCC chúng mình có các danh mục sản phẩm sau:\n\n- Bóng đá\n- Cầu lông\n- Bóng rổ\n\nBạn quan tâm đến danh mục sản phẩm nào ạ? Mình sẽ cung cấp thêm thông tin chi tiết cho bạn nhé!', '2024-11-11 12:35:34'),
(25, NULL, NULL, 'có áo MU không', '7TCC: Chào bạn, hiện tại 7TCC chúng mình có áo MU. Bạn có thể đặt hàng trực tiếp qua website hoặc đến trực tiếp cửa hàng để xem và mua sản phẩm.\n\nThông tin sản phẩm:\n\n**Áo MU**\n- Mã SP: mu023\n- Giá: 400.000đ\n- Số lượng còn lại: 99\n- Mô tả: mu\n\nBạn có nhu cầu đặt hàng hoặc được tư vấn thêm về sản phẩm này không ạ?', '2024-11-11 12:35:52'),
(26, NULL, NULL, 'có áo Juventus không', 'Chào bạn, hiện tại 7TCC chúng mình không có sản phẩm áo Juventus. Bạn có nhu cầu đặt hàng sản phẩm này không ạ?', '2024-11-11 12:36:24'),
(27, NULL, NULL, 'có', 'Chào bạn, hiện tại 7TCC chúng mình có những sản phẩm sau:\n\n**Bóng đá:**\n- Áo MC (Mã SP: 5)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- Áo MU (Mã SP: mu023)\n\n**Cầu lông:**\n- Áo Yonex (Mã SP: ynex123)\n- Áo cầu lông 2 (Mã SP: ynex2)\n- Áo cầu lông 3 (Mã SP: ynex3)\n- Áo cầu lông 4 (Mã SP: ynex4)\n- Áo cầu lông 5 (Mã SP: ynex5)\n- Áo cầu lông 6 (Mã SP: ynex6)\n\n**Bóng rổ:**\n- Áo bóng rổ 1 (Mã SP: br1)\n- Áo bóng rổ 2 (Mã SP: br2)\n- Áo bóng rổ 3 (Mã SP: br3)\n- Áo bóng rổ 4 (Mã SP: br4)\n- Áo bóng rổ 5 (Mã SP: br5)\n\nBạn quan tâm đến sản phẩm nào ạ? Mình sẽ cung cấp thêm thông tin chi tiết cho bạn nhé!', '2024-11-11 12:36:36'),
(28, NULL, NULL, 'Áo cầu lông 6 thì sao', 'Chào bạn, hiện tại 7TCC chúng mình còn **93** sản phẩm **Áo cầu lông 6** (Mã SP: ynex6).\n\nSản phẩm có mức giá là **400.000đ**.\n\nBạn có nhu cầu tìm hiểu thêm thông tin về sản phẩm hoặc đặt mua sản phẩm này không ạ?', '2024-11-11 12:36:37'),
(29, NULL, NULL, 'kể tên các sản phẩm trong danh mục có id 52', 'Chào bạn, danh mục sản phẩm có ID 52 là **Bóng đá**. Dưới đây là danh sách sản phẩm trong danh mục này:\n\n- Áo MC (Mã SP: 5)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- áo mới (Mã SP: 1230)\n- Áo MU (Mã SP: mu023)\n\nBạn có nhu cầu tìm hiểu thêm thông tin về sản phẩm nào ạ? Mình sẽ cung cấp thêm thông tin chi tiết cho bạn nhé!', '2024-11-11 12:37:48'),
(30, 'ngoctuan090904@gmail.com', NULL, 'tôi muốn mua áo cầu lông hãy tư vấn', 'Xin chào bạn, cảm ơn bạn đã quan tâm đến sản phẩm áo cầu lông của 7TCC. Hiện tại, chúng tôi có sẵn các sản phẩm áo cầu lông với thông tin như sau:\n\n- Áo Yonex, mã sản phẩm: ynex123, giá 400.000đ, số lượng còn lại: 98, mô tả: yonex.\n- Áo cầu lông 2, mã sản phẩm: ynex2, giá 400.000đ, số lượng còn lại: 100, mô tả: .\n- Áo cầu lông 3, mã sản phẩm: ynex3, giá 400.000đ, số lượng còn lại: 100, mô tả: .\n- Áo cầu lông 4, mã sản phẩm: ynex4, giá 400.000đ, số lượng còn lại: 97, mô tả: .\n- Áo cầu lông 5, mã sản phẩm: ynex5, giá 400.000đ, số lượng còn lại: 95, mô tả: .\n- Áo cầu lông 6, mã sản phẩm: ynex6, giá 400.000đ, số lượng còn lại: 93, mô tả: .\n\nBạn có thể truy cập website hoặc liên hệ với chúng tôi qua số hotline 0938688079 để được hỗ trợ tư vấn chi tiết hơn về sản phẩm và cách thức đặt hàng.', '2024-11-11 12:40:26'),
(31, 'ngoctuan090904@gmail.com', NULL, 'cho tôi xem mẫu mã của áo số 5', 'Xin chào bạn, cảm ơn bạn đã quan tâm đến sản phẩm áo cầu lông số 5 của chúng tôi. Hiện tại, chúng tôi không có hình ảnh mẫu mã của sản phẩm này. Tuy nhiên, bạn có thể truy cập website của chúng tôi để xem các sản phẩm có sẵn hoặc liên hệ với chúng tôi qua số hotline 0938688079 để được hỗ trợ trực tiếp.', '2024-11-11 12:40:56'),
(32, 'ngoctuan090904@gmail.com', NULL, 'giúp tôi đặt hàng áo số 5', 'Xin chào bạn, cảm ơn bạn đã đặt hàng tại 7TCC. Để đặt hàng áo cầu lông số 5, mã sản phẩm: ynex5, giá 400.000đ, còn lại 95 sản phẩm, bạn vui lòng cung cấp cho chúng tôi các thông tin sau:\n\n- Họ và tên:\n- Số điện thoại:\n- Địa chỉ nhận hàng:\n- Size áo:\n- Số lượng sản phẩm:\n\nSau khi nhận được các thông tin trên, chúng tôi sẽ tiến hành xác nhận đơn hàng và gửi mã đơn hàng cho bạn. Chúng tôi sẽ giao hàng trong vòng 3-5 ngày làm việc và bạn có thể thanh toán bằng COD, chuyển khoản hoặc Momo khi nhận hàng.\n\nNếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua hotline 0938688079 để được hỗ trợ.', '2024-11-11 12:41:17'),
(33, 'thinhgpt1706@gmail.com', NULL, 'danh mục 52 là danh mục gì', 'Chúng mình không có danh mục nào có tên gọi là \"danh mục 52\". Bạn vui lòng cung cấp lại thông tin về danh mục mà bạn thắc mắc để chúng mình kiểm tra chính xác nhé!', '2024-11-11 12:41:19'),
(34, 'thinhgpt1706@gmail.com', NULL, 'ý tôi là danh mục có id 52', 'Chào bạn, chúng mình không có danh mục nào có ID là 52. Bạn có thể cung cấp thêm thông tin về danh mục mà bạn muốn hỏi không? Hoặc nếu bạn muốn đặt hàng sản phẩm, bạn có thể truy cập website của chúng mình tại https://7tcc.vn/ để tham khảo danh sách sản phẩm và đặt hàng trực tiếp nhé!', '2024-11-11 12:41:31'),
(35, 'ngoctuan090904@gmail.com', NULL, 'có sản phẩm nào mới ra mắt không', 'Xin chào bạn, hiện tại chúng tôi chưa có sản phẩm mới nào ra mắt. Tuy nhiên, chúng tôi sẽ cập nhật các sản phẩm mới nhất trên website và các kênh truyền thông của 7TCC. Bạn có thể truy cập website hoặc liên hệ với chúng tôi qua số hotline 0938688079 để được thông báo về các sản phẩm mới nhất.', '2024-11-11 12:42:17'),
(36, 'thinhgpt1706@gmail.com', NULL, 'áo bóng rổ gồm có áo nào', 'Chào bạn, hiện tại danh mục áo bóng rổ trên website của 7TCC có các sản phẩm sau:\n\n- **Áo bóng rổ 1** (Mã SP: br1): 300.000đ - Còn 99 sản phẩm\n- **Áo bóng rổ 2** (Mã SP: br2): 300.000đ - Còn 98 sản phẩm\n- **Áo bóng rổ 3** (Mã SP: br3): 300.000đ - Còn 95 sản phẩm\n- **Áo bóng rổ 4** (Mã SP: br4): 300.000đ - Còn 83 sản phẩm\n\nBạn có thể truy cập website của chúng mình tại https://7tcc.vn/collections/ao-bong-ro để xem chi tiết từng sản phẩm nhé!', '2024-11-11 12:42:32'),
(37, 'thinhgpt1706@gmail.com', NULL, 'áo yonex thì sao', 'Chào bạn, danh mục áo Yonex trên website của 7TCC có các sản phẩm sau:\n\n- **Áo Yonex 123** (Mã SP: ynex123): 400.000đ - Còn 98 sản phẩm\n- **Áo cầu lông 2** (Mã SP: ynex2): 400.000đ - Còn 100 sản phẩm\n- **Áo cầu lông 3** (Mã SP: ynex3): 400.000đ - Còn 100 sản phẩm\n- **Áo cầu lông 4** (Mã SP: ynex4): 400.000đ - Còn 97 sản phẩm\n- **Áo cầu lông 5** (Mã SP: ynex5): 400.000đ - Còn 95 sản phẩm\n- **Áo cầu lông 6** (Mã SP: ynex6): 400.000đ - Còn 93 sản phẩm\n\nBạn có thể truy cập website của chúng mình tại https://7tcc.vn/collections/ao-cau-long để xem chi tiết từng sản phẩm nhé!', '2024-11-11 12:44:02'),
(38, 'thinhgpt1706@gmail.com', NULL, 'áo bóng rổ 4 còn bao nhiêu cái', 'Chào bạn, hiện tại sản phẩm **Áo bóng rổ 4** (Mã SP: br4) còn **83** sản phẩm ạ. Bạn có nhu cầu đặt hàng sản phẩm này không ạ?', '2024-11-11 12:45:22'),
(39, 'thinhgpt1706@gmail.com', NULL, 'bạn có thấy các sản phẩm áo mới trùng nhau không', 'Chào bạn, cảm ơn bạn đã phản hồi.\n\nĐúng vậy, chúng mình nhận thấy có 4 sản phẩm áo mới trong danh mục Bóng đá trùng nhau. Sản phẩm này có mã SP là 1230, với giá 100.000đ và mô tả là \"a\".\n\nChúng mình đã tiến hành kiểm tra lại hệ thống và đã xóa 3 sản phẩm trùng lặp đó. Hiện tại, chỉ còn 1 sản phẩm áo mới có mã SP 1230 trong danh mục Bóng đá.\n\nChúng mình rất xin lỗi vì sự cố này. Chúng mình sẽ cố gắng kiểm tra kỹ lưỡng hơn để tránh những sai sót tương tự trong tương lai.\n\nBạn có thể truy cập vào website của chúng mình tại https://7tcc.vn/ để xem lại danh sách sản phẩm đã cập nhật.\n\nMột lần nữa, chúng mình xin chân thành cảm ơn phản hồi của bạn. Nhờ có phản hồi của bạn, chúng mình có thể cải thiện chất lượng sản phẩm và dịch vụ của mình tốt hơn.', '2024-11-11 12:48:29'),
(40, 'thinhgpt1706@gmail.com', NULL, 'bạn có chắc bạn đã xóa chưa', 'Chào bạn, chúng mình xin xác nhận lại là đã xóa 3 sản phẩm áo mới trùng lặp trong danh mục Bóng đá. Hiện tại, chỉ còn 1 sản phẩm áo mới có mã SP 1230 trong danh mục này.\n\nBạn có thể truy cập lại website của chúng mình tại https://7tcc.vn/collections/ao-bong-da để kiểm tra lại thông tin sản phẩm nhé.\n\nNếu bạn vẫn gặp vấn đề về sản phẩm trùng lặp, vui lòng liên hệ trực tiếp với chúng mình qua hotline 0938688079 để được hỗ trợ nhanh nhất.', '2024-11-11 12:52:18'),
(41, NULL, NULL, 'link web này là gì', 'Chào bạn, link website của 7TCC là https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php nhé. Bạn có thể truy cập vào link này để tìm hiểu thông tin về các sản phẩm, chương trình khuyến mãi và chính sách của cửa hàng chúng mình.', '2024-11-11 12:57:07'),
(42, NULL, NULL, 'link web này là gì', 'Chào bạn, link website của 7TCC là https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php nhé. Bạn có thể truy cập vào link này để tìm hiểu thông tin về các sản phẩm, chương trình khuyến mãi và chính sách của cửa hàng chúng mình.', '2024-11-11 13:00:50'),
(43, NULL, NULL, 'bạn là ai', 'Chào bạn, mình là 7TCC, trợ lý AI hỗ trợ khách hàng của 7TCC - Thương hiệu thời trang thể thao được phát triển bởi nhóm 8 sinh viên Đại học Sài Gòn. Bạn cần mình hỗ trợ điều gì ạ?', '2024-11-11 13:01:02'),
(44, NULL, NULL, 'web này là web gì', 'Chào bạn, đây là website chính thức của 7TCC - Thương hiệu thời trang thể thao được phát triển bởi nhóm 8 sinh viên Đại học Sài Gòn. Bạn có thể truy cập vào website này để tìm hiểu thông tin về các sản phẩm, chương trình khuyến mãi và chính sách của cửa hàng 7TCC.\n\nLink website: https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php', '2024-11-11 13:03:13'),
(45, NULL, NULL, 'hi', 'Xin chào bạn! Rất vui được hỗ trợ bạn. Bạn có cần mình tư vấn về sản phẩm, chính sách hay bất kỳ thông tin gì của 7TCC không ạ?', '2024-11-11 13:04:54'),
(46, NULL, NULL, 'web này url là gì', 'Chào bạn, link website của 7TCC là https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php bạn nhé!', '2024-11-11 13:05:04'),
(47, NULL, NULL, 'áo bóng rổ 4 còn bao nhiêu cái', 'Áo bóng rổ 4 mã SP: br4 còn 83 cái bạn nhé!', '2024-11-11 13:05:42'),
(48, NULL, NULL, '1+1= mấy', 'Chào bạn, mình là trợ lý AI, không thể thực hiện phép tính toán học. Bạn có cần mình hỗ trợ điều gì liên quan đến sản phẩm hoặc dịch vụ của 7TCC không ạ?', '2024-11-11 13:09:23'),
(49, NULL, NULL, 'cứ tính đi', 'Chào bạn, mình chỉ là trợ lý AI hỗ trợ thông tin về cửa hàng thời trang thể thao 7TCC, không thể thực hiện phép tính toán học. Bạn vui lòng liên hệ trực tiếp qua hotline: 0909888888 để được hỗ trợ tốt nhất nhé!', '2024-11-11 13:09:37'),
(50, NULL, NULL, 'ok, tôi cao 1m81 nặng 76kg mặc size nào', 'Chào bạn! Dựa trên chiều cao và cân nặng của bạn, mình gợi ý bạn chọn size áo XL nhé. Nhưng để chắc chắn hơn, bạn vui lòng cung cấp cho mình số đo vòng ngực và vòng bụng để mình tư vấn chính xác hơn cho bạn nhé!', '2024-11-11 13:10:16'),
(51, NULL, NULL, 'cút', 'Chào bạn, mình là trợ lý AI của 7TCC, mình ở đây để hỗ trợ bạn. Vui lòng liên hệ trực tiếp qua hotline: 0909888888 để được phục vụ tốt nhất nhé!', '2024-11-12 06:21:03'),
(52, NULL, NULL, 'cac', 'Chào bạn, bạn cần hỗ trợ thông tin gì về sản phẩm hoặc dịch vụ của thời trang thể thao 7TCC ạ?', '2024-11-12 06:21:13'),
(53, NULL, NULL, 'tao fan mu', 'Chào bạn, mình hiểu bạn là fan của đội bóng Manchester United. 7TCC hiện có áo đấu chính thức của MU với giá 400.000đ, size áo từ S đến XXL. Bạn muốn đặt áo size nào ạ?', '2024-11-12 06:21:25'),
(54, NULL, NULL, 'xl', 'Chào bạn, bạn cần size XL áo đấu MU đúng không ạ? Mình sẽ kiểm tra số lượng còn lại giúp bạn nhé. Vui lòng cung cấp cho mình địa chỉ và số điện thoại để mình lên đơn hàng và tiến hành giao hàng cho bạn nhé!', '2024-11-12 06:21:41'),
(55, NULL, NULL, 'bạn biết ĐPT kh?', 'Bạn ơi, ĐPT là gì vậy ạ? Bạn có thể vui lòng giải thích rõ hơn không?', '2024-11-13 01:38:43'),
(56, NULL, NULL, 'mình cần mua áo bóng rổ', 'Xin chào bạn, 7TCC hiện có nhiều mẫu áo bóng rổ với nhiều size khác nhau. Bạn có thể tham khảo một số mẫu áo bóng rổ tại danh mục Bóng rổ trên website của chúng tôi: https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php.\n\nBạn có thể cung cấp cho mình thông tin về chiều cao và cân nặng để mình có thể tư vấn size áo phù hợp cho bạn nhé!', '2024-11-13 01:39:06'),
(57, NULL, NULL, 'mình cần mua áo dú', 'Xin chào bạn, 7TCC không có bán áo dú trong danh sách sản phẩm hiện tại. Bạn có thể tham khảo các sản phẩm áo bóng rổ khác tại danh mục Bóng rổ trên website của chúng tôi: https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php.', '2024-11-13 01:39:15'),
(58, NULL, NULL, 'mình muốn mua áo MU', 'Xin chào bạn, 7TCC hiện có áo đấu chính thức của MU với giá 400.000đ, size áo từ S đến XXL. Bạn muốn đặt áo size nào ạ?', '2024-11-13 01:40:10'),
(59, NULL, NULL, 'có size XXXL không ạ', 'Xin chào bạn, hiện tại chúng tôi không còn size XXXL áo đấu MU. Các size áo hiện tại còn hàng là từ S đến XXL. Bạn muốn đặt size áo nào ạ?', '2024-11-13 01:40:37'),
(60, NULL, NULL, 'có size TMLDPT không ạ', 'Xin chào bạn, 7TCC không có áo đấu có size TMLDPT. Các size áo hiện tại còn hàng là từ S đến XXL. Bạn muốn đặt size áo nào ạ?', '2024-11-13 01:40:51'),
(61, NULL, NULL, '\'', 'Xin chào bạn. 7TCC hiện có những mẫu áo bóng đá, cầu lông, bóng rổ với nhiều kiểu dáng và kích cỡ khác nhau. Bạn có thể tham khảo thêm tại website của chúng tôi: https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php. Bạn đang tìm mẫu áo nào vậy ạ?', '2024-11-13 01:41:08'),
(62, NULL, NULL, 'mình tìm mẫu \'', '7TCC: Xin chào bạn, bạn có thể cung cấp thêm thông tin về mẫu áo mà bạn đang tìm không ạ? Bạn đang tìm mẫu áo trong danh mục sản phẩm nào (bóng đá, cầu lông hoặc bóng rổ)? Hoặc bạn có thể cung cấp thêm đặc điểm về kiểu dáng, màu sắc hoặc chất liệu áo mà bạn đang muốn tìm không ạ?', '2024-11-13 01:41:21'),
(63, NULL, NULL, 'mình cần một cái áo màu đỏ', 'Xin chào bạn, 7TCC hiện có các mẫu áo màu đỏ ở cả 3 danh mục sản phẩm bóng đá, cầu lông và bóng rổ:\n\n- Danh mục bóng đá:\n  + Áo MC: Giá 400.000đ, số lượng còn lại 1, size S đến XXL\n  + Áo MU: Giá 400.000đ, số lượng còn lại 99, size S đến XXL\n\n- Danh mục cầu lông:\n  + Áo Yonex: Giá 400.000đ, số lượng còn lại 98, size M đến XXL\n\n- Danh mục bóng rổ:\n  + Áo bóng rổ 1: Giá 300.000đ, số lượng còn lại 99, size M đến XXL\n  + Áo bóng rổ 3: Giá 300.000đ, số lượng còn lại 95, size M đến XXL\n\nBạn quan tâm đến mẫu áo nào ạ?', '2024-11-13 01:41:40'),
(64, 'ngoctuan090904@gmail.com', NULL, 'có bán sản phẩm bóng chuyền nào không', 'Xin chào bạn, cảm ơn bạn đã quan tâm đến sản phẩm của 7TCC. Hiện tại, chúng tôi chưa có sản phẩm bóng chuyền nào trong danh mục sản phẩm. Tuy nhiên, bạn có thể truy cập website hoặc liên hệ với chúng tôi qua số hotline 0909888888 để được thông báo về các sản phẩm mới nhất của chúng tôi. Chúng tôi sẽ cập nhật các sản phẩm mới nhất trên website và các kênh truyền thông của 7TCC.', '2024-11-15 03:26:45'),
(65, 'ngoctuan090904@gmail.com', NULL, 'có bán áo Lake không', 'Xin chào bạn, hiện tại chúng tôi không có sản phẩm áo Lake trong danh mục sản phẩm. Tuy nhiên, bạn có thể truy cập website của chúng tôi hoặc liên hệ với chúng tôi qua số hotline 0909888888 để được thông báo về các sản phẩm mới nhất của chúng tôi. Chúng tôi sẽ cập nhật các sản phẩm mới nhất trên website và các kênh truyền thông của 7TCC.', '2024-11-15 03:27:02'),
(66, 'ngoctuan090904@gmail.com', NULL, 'áo cầu lông có không', 'Xin chào bạn, hiện tại chúng tôi có các mẫu áo cầu lông sau:\n\n- Áo Yonex, mã sản phẩm: ynex123, giá 400.000đ, còn lại 98 sản phẩm, mô tả: yonex\n- Áo cầu lông 2, mã sản phẩm: ynex2, giá 400.000đ, còn lại 100 sản phẩm\n- Áo cầu lông 3, mã sản phẩm: ynex3, giá 400.000đ, còn lại 100 sản phẩm\n- Áo cầu lông 4, mã sản phẩm: ynex4, giá 400.000đ, còn lại 97 sản phẩm\n- Áo cầu lông 5, mã sản phẩm: ynex5, giá 400.000đ, còn lại 95 sản phẩm\n- Áo cầu lông 6, mã sản phẩm: ynex6, giá 400.000đ, còn lại 93 sản phẩm\n\nBạn có thể truy cập website của chúng tôi để xem thêm thông tin chi tiết về các sản phẩm này hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được tư vấn cụ thể hơn.', '2024-11-15 03:27:23'),
(67, 'ngoctuan090904@gmail.com', NULL, 'chỉ đưa tên áo', 'Xin chào bạn, hiện tại chúng tôi có các mẫu áo sau:\n\n- Áo MC\n- Áo MU\n- Áo Yonex\n- Áo cầu lông 2\n- Áo cầu lông 3\n- Áo cầu lông 4\n- Áo cầu lông 5\n- Áo cầu lông 6\n- Áo bóng rổ 1\n- Áo bóng rổ 2\n- Áo bóng rổ 3\n- Áo bóng rổ 4\n\nBạn có thể truy cập website của chúng tôi để xem thêm thông tin chi tiết về các sản phẩm này hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được tư vấn cụ thể hơn.', '2024-11-15 03:28:42'),
(68, 'ngoctuan090904@gmail.com', NULL, 'khoa cntt truong dai hoc sai gon', 'Xin chào bạn, bạn đang trò chuyện với trợ lý AI của 7TCC, một thương hiệu thời trang thể thao được phát triển bởi nhóm 8 sinh viên Khoa Công nghệ thông tin, Trường Đại học Sài Gòn.\n\nRất vui được hỗ trợ bạn!', '2024-11-15 04:12:17'),
(69, 'ngoctuan090904@gmail.com', NULL, 'ao bong ro 3 thong tin', 'Xin chào bạn, hiện tại chúng tôi có sản phẩm áo bóng rổ 3 với thông tin như sau:\n\n- Mã sản phẩm: br3\n- Giá: 300.000đ\n- Số lượng còn lại: 93\n- Mô tả: áo bóng rổ 3\n\nBạn có thể truy cập website của chúng tôi để xem thêm thông tin chi tiết về sản phẩm này hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được tư vấn cụ thể hơn.', '2024-11-15 04:14:54'),
(70, 'ngoctuan090904@gmail.com', NULL, 'gioi thieu cho toi ve ao bong ro 3, khac voi nhung thong tin nay', 'Ngoài những thông tin đã nêu, áo bóng rổ 3 còn có những đặc điểm nổi bật sau:\n\n- Chất liệu vải cao cấp, thoáng mát, thấm hút mồ hôi tốt, giúp bạn luôn thoải mái khi vận động.\n- Thiết kế thời trang, năng động, phù hợp với mọi lứa tuổi và phong cách.\n- Logo 7TCC in nổi bật trên ngực áo, tạo điểm nhấn ấn tượng.\n- Đường may chắc chắn, tỉ mỉ, đảm bảo độ bền của sản phẩm.\n- Phù hợp cho nhiều hoạt động thể thao khác nhau, không chỉ riêng bóng rổ.\n\nNếu bạn đang tìm kiếm một chiếc áo bóng rổ vừa chất lượng vừa thời trang, thì áo bóng rổ 3 của 7TCC chính là sự lựa chọn hoàn hảo. Hãy liên hệ với chúng tôi qua hotline 0909888888 để được tư vấn cụ thể hơn và đặt hàng ngay hôm nay!', '2024-11-15 04:15:40'),
(71, NULL, NULL, 'hi', 'Xin chào, mình có thể giúp gì bạn?', '2024-12-01 05:24:16'),
(72, NULL, NULL, 'Vợt coka 6900 có không', 'Xin chào bạn, hiện tại chúng tôi không có sản phẩm vợt Coka 6900.\n\nĐể biết thêm thông tin chi tiết về các sản phẩm khác, bạn có thể truy cập website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888.\n\nCảm ơn bạn đã quan tâm đến 7TCC!', '2024-12-01 14:07:26'),
(73, NULL, NULL, 'Gà', 'Xin chào bạn, sản phẩm bạn đang tìm hiện không có trong danh mục sản phẩm của chúng tôi. Hãy truy cập website https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được hỗ trợ tốt nhất. Xin cảm ơn!', '2024-12-01 14:07:37'),
(74, NULL, NULL, 'Vợt kumpo k250 có không', '7TCC: Xin chào bạn, hiện tại chúng tôi không có sản phẩm vợt Kumpo K250.\n\nĐể biết thêm thông tin chi tiết về các sản phẩm khác, bạn có thể truy cập website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888.\n\nCảm ơn bạn đã quan tâm đến 7TCC!', '2024-12-01 14:08:10'),
(75, NULL, NULL, 'Vợt kumpo k520', '7TCC: Xin chào bạn, hiện tại chúng tôi không có sản phẩm vợt Kumpo K520.\n\nĐể biết thêm thông tin chi tiết về các sản phẩm khác, bạn có thể truy cập website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888.\n\nCảm ơn bạn đã quan tâm đến 7TCC!', '2024-12-01 14:08:32'),
(76, NULL, NULL, 'Áo power flex', '7TCC: Xin chào, bạn đang quan tâm đến sản phẩm Áo Power Flex của chúng tôi.\n\n* Sản phẩm này có giá 420.000đ/chiếc.\n* Hiện tại chúng tôi còn 74 sản phẩm trong kho.\n* Áo Power Flex là loại áo cầu lông với sự kết hợp giữa sức mạnh và linh hoạt, phù hợp cho những người chơi đang tìm kiếm một chiếc áo có thể hỗ trợ họ trong cả tấn công và phòng thủ.\n\nBạn có thể truy cập website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để đặt hàng hoặc được tư vấn chi tiết hơn.\n\nCảm ơn bạn đã quan tâm đến 7TCC!', '2024-12-01 14:08:55'),
(77, NULL, NULL, 'Tìm giày đá banh có thể chơi được trong sân cầu', 'Xin chào bạn, rất tiếc chúng tôi không có sản phẩm giày đá banh có thể chơi được trong sân cầu. Bạn có thể ghé thăm website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được hỗ trợ tốt nhất. Xin cảm ơn!', '2024-12-01 14:09:29'),
(78, NULL, NULL, 'Giày thể thao giá rẻ', 'Xin chào bạn,\n\nCảm ơn bạn đã quan tâm đến giày thể thao của chúng tôi. Hiện tại chúng tôi không có sản phẩm giày thể thao giá rẻ.\n\nBạn có thể ghé thăm website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được hỗ trợ tốt nhất. Xin cảm ơn bạn!', '2024-12-01 14:09:49'),
(79, NULL, NULL, 'Thế giá mắc có không', 'Cảm ơn bạn đã quan tâm đến sản phẩm của chúng tôi. Hiện tại, chúng tôi không có sản phẩm giày thể thao giá rẻ. Tuy nhiên, chúng tôi có nhiều sản phẩm giày thể thao chất lượng cao với giá cả hợp lý.\n\nBạn có thể ghé thăm website của chúng tôi tại https://web7tcc-a9aaa5d624b4.herokuapp.com/index.php hoặc liên hệ trực tiếp với chúng tôi qua hotline 0909888888 để được hỗ trợ tốt nhất. Xin cảm ơn bạn!', '2024-12-01 14:10:19'),
(80, 'zaikaman123@gmail.com', NULL, 'ccho ttv', 'Chào bạn, 7TCC xin chào! Bạn cần hỗ trợ gì ạ? Mình luôn sẵn sàng tư vấn cho bạn những mẫu áo thể thao phù hợp nhất! ????\n', '2025-09-09 06:13:05'),
(81, 'zaikaman123@gmail.com', NULL, 'con chó tran trung viet', 'Chào bạn, 7TCC xin chào! Bạn có thể cho mình biết bạn quan tâm đến sản phẩm nào của 7TCC không ạ? Bên mình có rất nhiều mẫu áo thể thao cho bóng đá, bóng rổ, bóng chuyền và cầu lông đó ạ. Mình sẽ tư vấn chi tiết về giá cả, số lượng và mô tả của sản phẩm để bạn dễ dàng lựa chọn nhé! ????\n', '2025-09-09 06:13:19'),
(82, 'zaikaman123@gmail.com', NULL, 'có áo nào', 'Chào bạn, 7TCC xin chào! Bạn quan tâm đến áo thể thao của môn nào ạ? Bên mình có rất nhiều mẫu áo cho bóng đá, bóng rổ, bóng chuyền và cầu lông đó ạ. Bạn có thể cho mình biết bạn thích loại áo nào hơn để mình tư vấn chi tiết nhé!\n', '2025-09-09 06:13:29'),
(83, 'zaikaman123@gmail.com', NULL, 'áo bóng đá', 'Chào bạn, 7TCC xin chào! Bên mình có rất nhiều mẫu áo bóng đá đẹp và chất lượng ạ. Bạn có thể cho mình biết bạn thích áo của đội bóng nào, hoặc bạn có yêu cầu đặc biệt nào về màu sắc, kiểu dáng hay chất liệu không ạ? Mình sẽ giúp bạn tìm được chiếc áo ưng ý nhất! ????\n', '2025-09-09 06:13:37'),
(84, 'zaikaman123@gmail.com', NULL, 'manchester united', 'Chào bạn, 7TCC xin chào! Bạn quan tâm đến áo Manchester United đúng không ạ? Bên mình có 2 mẫu áo Manchester United rất được ưa chuộng đó là:\n\n*   **Áo Sân Nhà Manchester United 2023 2024**\n    *   Mã SP: MNUH2324\n    *   Giá: 250.000đ\n    *   Số lượng còn lại: 100\n    *   Mô tả: Áo đấu sân nhà của Manchester United cho mùa giải 2023-2024 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu đỏ tươi, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.\n*   **Áo Sân Nhà Manchester United 2024 2025**\n    *   Mã SP: MNUH2425\n    *   Giá: 350.000đ\n    *   Số lượng còn lại: 199\n    *   Mô tả: Áo đấu nhà Manchester United mùa 2024-2025 được thiết kế bởi adidas và ra mắt vào ngày 1 tháng 7 năm 2024. Thiết kế áo này tạo ấn tượng mạnh mẽ với sự kết hợp của hai màu đỏ, từ đỏ nhạt đến đỏ sẫm, tạo hiệu ứng ánh sáng độc đáo khi ánh sáng Old Trafford chiếu lên. Áo đấu này có thêm một khối màu đỏ rực rỡ trên tay áo và quần, tạo thành một đường kết nối đặc biệt.\n\nBạn thích mẫu áo nào hơn ạ? Mình có thể tư vấn thêm về size hoặc giải đáp bất kỳ thắc mắc nào của bạn nhé! Nếu bạn cần tư vấn gấp, đừng ngần ngại gọi hotline 0909888888 để được hỗ trợ nhanh nhất ạ!\n', '2025-09-09 06:13:47'),
(85, 'zaikaman123@gmail.com', NULL, 'có áo MU nào chất ko', 'Chào bạn, 7TCC xin chào! ????\n\nBạn muốn tìm áo MU chất lượng cao đúng không ạ? Bên mình có hai mẫu áo Manchester United mà mình thấy rất đáng để bạn tham khảo, cả về thiết kế lẫn chất liệu đó:\n\n1.  **Áo Sân Nhà Manchester United 2024 2025** (Mã SP: MNUH2425)\n\n    *   **Giá:** 350.000đ\n    *   **Số lượng:** Hiện còn 199 chiếc\n    *   **Mô tả:** Mẫu áo này là thiết kế mới nhất của mùa giải 2024-2025, do Adidas thiết kế. Điểm đặc biệt là sự kết hợp giữa hai tông màu đỏ đậm nhạt, tạo hiệu ứng ánh sáng rất độc đáo khi mặc lên người, đặc biệt là khi bạn xem đá bóng ở sân Old Trafford đó ạ! Áo còn có thêm những mảng màu đỏ rực trên tay áo và quần, tạo sự liền mạch và nổi bật.\n2.  **Áo Sân Nhà Manchester United 2023 2024** (Mã SP: MNUH2324)\n\n    *   **Giá:** 250.000đ (Giá mềm hơn mẫu mới một chút ạ ????)\n    *   **Số lượng:** Hiện còn 100 chiếc\n    *   **Mô tả:** Mẫu áo này là phiên bản của mùa giải trước, 2023-2024. Thiết kế chủ đạo vẫn là màu đỏ tươi truyền thống, mang đến sự trẻ trung và năng động. Nếu bạn thích phong cách cổ điển và đơn giản hơn thì mẫu này sẽ phù hợp hơn đó ạ.\n\nCả hai mẫu áo đều được làm từ chất liệu thấm hút mồ hôi tốt, giúp bạn thoải mái khi vận động hoặc mặc hàng ngày.\n\nBạn có muốn mình tư vấn thêm về size áo, hoặc có bất kỳ thắc mắc nào về chất liệu, chính sách đổi trả không ạ? Nếu bạn cần tư vấn nhanh chóng, đừng ngần ngại gọi ngay hotline 0909888888 để được hỗ trợ nhé! Rất vui được phục vụ bạn! ????\n', '2025-09-09 06:15:16'),
(86, 'zaikaman123@gmail.com', NULL, 'hello', 'Chào bạn, 7TCC xin chào! ???? Rất vui vì bạn đã liên hệ với 7TCC. Bạn có thể cho mình biết bạn quan tâm đến sản phẩm nào của bên mình không ạ? ????\n\n7TCC hiện đang có rất nhiều mẫu áo thể thao cực chất cho bóng đá, bóng rổ, bóng chuyền và cầu lông đó. Mình sẽ nhiệt tình tư vấn chi tiết về giá cả, số lượng, chất liệu và mô tả sản phẩm để bạn có thể dễ dàng lựa chọn được chiếc áo ưng ý nhất nha! ✨\n', '2025-09-09 06:23:19'),
(87, 'zaikaman123@gmail.com', NULL, 'yo', 'Chào bạn, 7TCC xin chào! ✨ Yo! Bạn đang \"lướt\" 7TCC và cần tìm đồ thể thao chất lừ đúng không ạ? Bên mình có đủ các loại áo cho bóng đá, bóng rổ, bóng chuyền và cầu lông đó nha! \n\nBạn đang nhắm tới môn nào hay có phong cách nào \"gu\" của bạn không? Để mình \"quăng\" cho bạn vài gợi ý \"cool ngầu\" nè! ????\n', '2025-09-09 06:26:20'),
(88, 'zaikaman123@gmail.com', NULL, 'hi', 'Chào bạn, 7TCC xin chào! ✨ Hi! Rất vui được hỗ trợ bạn hôm nay. Bạn đang tìm kiếm sản phẩm thể thao nào ạ? Bên mình có rất nhiều mẫu áo thể thao chất lượng cho các môn bóng đá, bóng rổ, bóng chuyền và cầu lông đó.\n\nBạn có thể chia sẻ thêm về nhu cầu của mình để mình tư vấn cụ thể hơn nha! Ví dụ như:\n\n*   Bạn quan tâm đến môn thể thao nào? (bóng đá, bóng rổ, bóng chuyền, cầu lông)\n*   Bạn muốn tìm áo của đội bóng/ câu lạc bộ nào không?\n*   Bạn có yêu cầu đặc biệt nào về kiểu dáng, màu sắc, chất liệu không?\n\nĐừng ngại chia sẻ nha, mình sẽ giúp bạn tìm được sản phẩm ưng ý nhất! ????\n', '2025-09-09 06:29:17'),
(89, 'zaikaman123@gmail.com', NULL, 'hi', 'Chào bạn, 7TCC xin chào! ✨ Hi! Rất vui được hỗ trợ bạn hôm nay. Bạn đang tìm kiếm sản phẩm thể thao nào ạ? Bên mình có rất nhiều mẫu áo thể thao chất lượng cho các môn bóng đá, bóng rổ, bóng chuyền và cầu lông đó.\n\nĐể mình có thể tư vấn tốt nhất, bạn có thể cho mình biết bạn quan tâm đến môn thể thao nào không ạ? Hoặc bạn đang tìm kiếm áo của đội bóng/câu lạc bộ nào không? Bất kỳ thông tin nào bạn chia sẻ sẽ giúp mình tìm được sản phẩm phù hợp với bạn nhất đó! ????\n', '2025-09-09 06:30:59'),
(90, 'zaikaman123@gmail.com', NULL, 'hi', 'Chào bạn, 7TCC xin chào! ✨ Hi! Rất vui được hỗ trợ bạn hôm nay. Bạn đang tìm kiếm sản phẩm thể thao nào ạ? Bên mình có rất nhiều mẫu áo thể thao chất lượng cho các môn bóng đá, bóng rổ, bóng chuyền và cầu lông đó.\n\nĐể mình có thể tư vấn tốt nhất, bạn có thể cho mình biết bạn quan tâm đến môn thể thao nào không ạ? Hoặc bạn đang tìm kiếm áo của đội bóng/câu lạc bộ nào không? Bất kỳ thông tin nào bạn chia sẻ sẽ giúp mình tìm được sản phẩm phù hợp với bạn nhất đó! ????\n', '2025-09-09 06:32:50'),
(91, 'zaikaman123@gmail.com', 'chat_1757399782981_b3c5qh58o', 'hi', 'Chào bạn! Mình là trợ lý ảo của 7TCC - Thương hiệu thời trang thể thao được phát triển bởi nhóm sinh viên Đại học Sài Gòn. Mình có thể giúp gì cho bạn hôm nay ạ? ????\n', '2025-09-09 06:36:31'),
(92, 'zaikaman123@gmail.com', 'chat_1757399794756_2tz26l3p5', 'hi', 'Chào bạn! Mình là trợ lý AI của 7TCC, rất vui được hỗ trợ bạn. Bạn đang quan tâm đến sản phẩm nào của 7TCC ạ? Mình có thể cung cấp thông tin chi tiết về giá cả, số lượng, mô tả sản phẩm, hoặc bất kỳ thông tin nào khác bạn cần. \n\nNgoài ra, mình cũng có thể giúp bạn:\n\n*   Hướng dẫn chọn size phù hợp.\n*   Giải đáp các thắc mắc về chính sách đổi trả, bảo hành.\n*   Tư vấn về phương thức thanh toán và vận chuyển.\n*   Hỗ trợ các vấn đề liên quan đến đơn hàng.\n\nHãy cho mình biết bạn cần hỗ trợ gì nhé!\n', '2025-09-09 06:36:40'),
(93, 'zaikaman123@gmail.com', 'chat_1757399809534_v6jxz49i0', 'hi', 'Chào bạn! Mình là trợ lý AI của 7TCC. Mình có thể giúp gì cho bạn ạ? Bạn đang quan tâm đến sản phẩm nào của 7TCC không?\n', '2025-09-09 06:36:55'),
(94, 'zaikaman123@gmail.com', 'chat_1757399865407_bw92k4aam', 'hi', 'Chào bạn! Mình là trợ lý AI của 7TCC, rất vui được hỗ trợ bạn. Bạn đang quan tâm đến sản phẩm nào của 7TCC ạ? Mình có thể giúp bạn tìm hiểu thông tin chi tiết về sản phẩm, tư vấn chọn size, giải đáp thắc mắc về chính sách của cửa hàng hoặc hỗ trợ bất cứ vấn đề gì liên quan đến đơn hàng. ????\n', '2025-09-13 07:57:40'),
(95, 'zaikaman123@gmail.com', 'chat_1757399865407_bw92k4aam', 'xin địa chỉ', 'Dạ chào bạn! Địa chỉ cửa hàng 7TCC của tụi mình là 273 An Dương Vương – Phường 3 – Quận 5 ạ. Bạn có cần mình hỗ trợ thêm thông tin gì nữa không ạ? ????\n', '2025-09-13 07:58:33'),
(96, 'zaikaman123@gmail.com', 'chat_1757399865407_bw92k4aam', 'xin địa chỉ web', 'Chào bạn! Địa chỉ website chính thức của 7TCC là: https://7tcc.great-site.net ạ. Bạn có cần mình hỗ trợ thêm thông tin gì về sản phẩm hay chính sách của cửa hàng không ạ? Mình luôn sẵn sàng giúp đỡ! ????\n', '2025-09-13 08:01:31'),
(97, 'zaikaman123@gmail.com', 'chat_1757755656160_2psxiq0st', 'hi', 'Chào bạn! 7TCC rất vui được hỗ trợ bạn. Bạn đang quan tâm đến sản phẩm nào của chúng mình ạ? Hãy cho mình biết để mình tư vấn chi tiết hơn nhé! ????\n', '2025-09-13 09:27:39'),
(98, 'zaikaman123@gmail.com', 'chat_1757759592013_x2jdnzq7s', 'hi', 'Chào bạn! Mình là trợ lý AI của 7TCC, rất vui được hỗ trợ bạn. Bạn đang quan tâm đến sản phẩm nào của 7TCC bên mình ạ? Mình có thể cung cấp thông tin chi tiết về sản phẩm, hướng dẫn chọn size, giải đáp thắc mắc về chính sách, hoặc hỗ trợ bất kỳ vấn đề nào khác liên quan đến đơn hàng. Bạn cứ thoải mái chia sẻ nhé! ????\n', '2025-09-13 10:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chitiet_gh`
--

CREATE TABLE `tbl_chitiet_gh` (
  `id_ctgh` int(11) NOT NULL,
  `ma_gh` varchar(100) NOT NULL,
  `id_sp` int(11) NOT NULL,
  `so_luong_mua` int(11) NOT NULL,
  `size` varchar(10) DEFAULT 'M'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chitiet_gh`
--

INSERT INTO `tbl_chitiet_gh` (`id_ctgh`, `ma_gh`, `id_sp`, `so_luong_mua`, `size`) VALUES
(14, '2946', 113, 1, 'M'),
(15, '8262', 114, 1, 'L'),
(16, '6879', 112, 1, 'M'),
(17, '3410', 113, 2, 'L'),
(18, '3410', 112, 2, 'M'),
(19, '2870', 113, 2, 'XL'),
(0, '68c125f6a3aa1', 220, 1, 'XXL'),
(0, '1757507613', 221, 3, 'M'),
(20, '2870', 112, 2, 'S'),
(21, '2870', 110, 3, 'M'),
(22, '4500', 104, 10, 'XL'),
(23, '8654', 114, 2, 'XXL'),
(26, '9405', 115, 5, 'S'),
(27, '9886', 115, 1, 'M'),
(28, '260', 116, 1, 'XL'),
(29, '7286', 116, 1, 'XXL'),
(30, '9014', 115, 1, 'S'),
(31, '9900', 116, 1, 'M'),
(32, '963', 116, 1, 'XL'),
(33, '1412', 116, 1, 'XXL'),
(34, '4051', 116, 1, 'S'),
(35, '7050', 116, 1, 'M'),
(36, '7411', 116, 1, 'XL'),
(37, '4146', 114, 1, 'XXL'),
(38, '9023', 114, 1, 'S'),
(39, '7587', 114, 1, 'M'),
(40, '478', 114, 2, 'XL'),
(41, '2100', 128, 2, 'XXL'),
(42, '1773', 128, 1, 'S'),
(43, '9875', 128, 1, 'M'),
(44, '6212', 128, 1, 'XL'),
(45, '5743', 128, 1, 'XXL'),
(46, '9191', 128, 1, 'S'),
(47, '9151', 128, 1, 'M'),
(48, '6486', 126, 1, 'XL'),
(49, '8436', 136, 2, 'XXL'),
(50, '7340', 137, 1, 'S'),
(51, '4302', 136, 1, 'M'),
(52, '6632', 136, 1, 'XL'),
(53, '843', 136, 1, 'XXL'),
(54, '7748', 136, 1, 'S'),
(55, '5935', 136, 1, 'M'),
(56, '7220', 137, 1, 'XL'),
(57, '7679', 137, 1, 'XXL'),
(58, '1535', 135, 1, 'S'),
(59, '588', 136, 1, 'M'),
(60, '5191', 116, 3, 'XL'),
(61, '5191', 137, 1, 'XXL'),
(62, '3520', 135, 1, 'S'),
(63, '8297', 136, 1, 'M'),
(64, '2247', 136, 1, 'XL'),
(65, '8995', 132, 2, 'XXL'),
(66, '7535', 137, 1, 'S'),
(67, '8420', 132, 1, 'M'),
(68, '5411', 137, 1, 'XL'),
(69, '5411', 125, 1, 'XXL'),
(70, '8749', 136, 1, 'S'),
(71, '8380', 136, 1, 'M'),
(72, '7436', 136, 1, 'XL'),
(73, '4190', 136, 1, 'XXL'),
(74, '6736', 135, 1, 'S'),
(75, '5487', 136, 1, 'M'),
(76, '7191', 137, 1, 'XL'),
(77, '8233', 131, 2, 'XXL'),
(78, '45', 131, 1, 'S'),
(79, '5781', 130, 1, 'M'),
(80, '2948', 135, 1, 'XL'),
(81, '3494', 114, 2, 'XXL'),
(82, '3494', 137, 1, 'S'),
(83, '1839', 137, 1, 'M'),
(84, '761', 137, 1, 'XL'),
(85, '4207', 137, 1, 'XXL'),
(86, '8393', 137, 1, 'S'),
(87, '4390', 137, 1, 'M'),
(88, '8612', 137, 1, 'XL'),
(89, '2092', 137, 1, 'XXL'),
(90, '4793', 137, 1, 'S'),
(91, '8538', 137, 1, 'M'),
(92, '4984', 137, 1, 'XL'),
(93, '3740', 137, 1, 'XXL'),
(94, '4207', 137, 2, 'S'),
(95, '2485', 137, 1, 'M'),
(96, '7680', 137, 1, 'XL'),
(97, '671a414c4c19a', 136, 1, 'XXL'),
(98, '671a4383ecb9b', 132, 1, 'S'),
(99, '671a444debad2', 127, 1, 'M'),
(100, '671a44cd85c83', 134, 1, 'XL'),
(101, '671a455319fee', 131, 1, 'XXL'),
(102, '671a7a343d8e3', 137, 1, 'S'),
(103, '672c69263562d', 137, 1, 'M'),
(104, '7120', 137, 1, 'XL'),
(105, '4234', 127, 1, 'XXL'),
(106, '9712', 134, 1, 'S'),
(107, '7692', 130, 1, 'M'),
(108, '672c792dd9fe3', 130, 2, 'XL'),
(109, '67315037b7010', 137, 1, 'XXL'),
(110, '6736bbf27cf43', 136, 1, 'S'),
(111, '3991', 135, 2, 'M'),
(112, '6736c7c56edfa', 131, 1, 'XL'),
(113, '1026', 131, 3, 'XXL'),
(114, '6740a84f28468', 135, 1, 'S'),
(115, '6740a9cdb27b9', 131, 1, 'M'),
(116, '7255', 133, 1, 'XL'),
(117, '7550', 135, 1, 'XXL'),
(118, '6743e336b5b7a', 129, 1, 'S'),
(119, '67493e0a6b8fb', 129, 2, 'M'),
(120, '674b3a347aa4a', 163, 1, 'XL'),
(121, '6984', 184, 1, 'XXL'),
(122, '674bdaa1966c1', 220, 2, 'S'),
(123, '674bdcce68b6a', 222, 1, 'M'),
(124, '674bdcfe92da9', 221, 1, 'XL'),
(125, '674bdd277d116', 220, 1, 'XXL'),
(126, '674bde2d2107d', 218, 5, 'S'),
(127, '2841', 217, 4, 'M'),
(128, '2841', 215, 1, 'XL'),
(129, '674bde81f1c4f', 215, 4, 'XXL'),
(130, '674be6ac478ea', 222, 2, 'S'),
(131, '674be8a702a18', 197, 1, 'M'),
(132, '2769', 199, 1, 'XL'),
(133, '4457', 153, 1, 'XXL'),
(134, '674bf0628551d', 172, 1, 'S'),
(135, '8835', 153, 1, 'M'),
(136, '2321', 170, 1, 'XL'),
(137, '7228', 188, 1, 'XXL'),
(138, '5955', 220, 1, 'S'),
(139, '674c077e9976a', 222, 2, 'M'),
(140, '674c2ee4c9070', 183, 1, 'XL'),
(141, '674c2efbc25c4', 150, 1, 'XXL'),
(142, '7511', 154, 1, 'S'),
(143, '674c38c81a9b2', 218, 2, 'M'),
(144, '674c3952ac6a8', 222, 1, 'XL'),
(145, '9683', 213, 1, 'XXL'),
(146, '674c3a6d2a95f', 195, 1, 'S'),
(147, '674c3a989d199', 181, 2, 'M'),
(148, '674c3a9f7cd07', 222, 1, 'XL'),
(149, '674c3a9f7cd07', 221, 1, 'XXL'),
(150, '674c3c95d3aab', 222, 1, 'S'),
(151, '674c3fd0e0d96', 222, 1, 'M'),
(152, '674c41589e279', 210, 1, 'XL'),
(153, '674c56a51a56f', 210, 1, 'XXL'),
(154, '674c57b6c851b', 210, 1, 'S'),
(155, '674c57ea8e53c', 221, 1, 'M'),
(156, '674c58205f123', 220, 1, 'XL'),
(157, '674c585775003', 219, 1, 'XXL'),
(158, '674c594ee2732', 198, 1, 'S'),
(159, '674c598515f16', 221, 1, 'M'),
(160, '674c59b8d2401', 221, 1, 'XL'),
(161, '636', 219, 1, 'XXL'),
(162, '674c59eca1f9f', 221, 1, 'S'),
(163, '674c5a1f34d06', 220, 1, 'M'),
(164, '890', 201, 1, 'XL'),
(165, '890', 162, 1, 'XXL'),
(166, '674c5a5d05930', 222, 1, 'S'),
(167, '8704', 202, 1, 'M'),
(168, '674c5a8b9e3a2', 221, 1, 'XL'),
(169, '4192', 182, 1, 'XXL'),
(170, '3557', 196, 1, 'S'),
(171, '674c5ae9e854b', 221, 1, 'M'),
(172, '674c5ae9e854b', 164, 1, 'XL'),
(173, '1214', 164, 1, 'XXL'),
(174, '674c5b27ddf1b', 221, 1, 'S'),
(175, '8786', 157, 1, 'M'),
(176, '7605', 199, 1, 'XL'),
(177, '674c5b7ab0578', 221, 1, 'XXL'),
(178, '674c5b7ab0578', 222, 1, 'S'),
(179, '802', 183, 1, 'M'),
(180, '802', 182, 1, 'XL'),
(181, '674c5bdd3d5f2', 222, 1, 'XXL'),
(182, '674c5bdd3d5f2', 221, 1, 'S'),
(183, '74', 180, 2, 'M'),
(184, '8810', 151, 1, 'XL'),
(185, '674c5c361194f', 220, 1, 'XXL'),
(186, '674c5c361194f', 219, 1, 'S'),
(187, '1547', 160, 1, 'M'),
(188, '4800', 188, 1, 'XL'),
(189, '674c5c8feda00', 222, 1, 'XXL'),
(190, '674c5c8feda00', 221, 1, 'S'),
(191, '4154', 142, 1, 'M'),
(192, '5462', 203, 1, 'XL'),
(193, '1238', 217, 1, 'XXL'),
(194, '8915', 214, 1, 'S'),
(195, '1083', 200, 1, 'M'),
(196, '3610', 157, 1, 'XL'),
(197, '2948', 153, 1, 'XXL'),
(198, '6538', 218, 1, 'S'),
(199, '438', 190, 1, 'M'),
(200, '4723', 184, 1, 'XL'),
(201, '9424', 215, 1, 'XXL'),
(202, '4597', 179, 1, 'S'),
(203, '9620', 189, 1, 'M'),
(204, '4746', 161, 1, 'XL'),
(205, '2851', 205, 1, 'XXL'),
(206, '8314', 176, 1, 'S'),
(207, '1708', 222, 1, 'M'),
(208, '674c633024694', 184, 1, 'XL'),
(209, '674c636329b39', 221, 1, 'XXL'),
(210, '674c6398a17f2', 221, 1, 'S'),
(211, '674c63cb03836', 221, 1, 'M'),
(212, '674c64059cc84', 222, 1, 'XL'),
(213, '674c6440cc0b3', 221, 1, 'XXL'),
(0, '68c40966246ad', 221, 10, 'XL'),
(0, '68c82da16256e', 221, 1, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dangky`
--

CREATE TABLE `tbl_dangky` (
  `id_dangky` int(11) NOT NULL,
  `ten_khachhang` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dia_chi` varchar(200) NOT NULL,
  `mat_khau` varchar(100) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `dien_thoai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dangky`
--

INSERT INTO `tbl_dangky` (`id_dangky`, `ten_khachhang`, `email`, `dia_chi`, `mat_khau`, `reset_token`, `reset_token_expires`, `dien_thoai`) VALUES
(14, 'ngọc tuấn', 'ngoctuan090904@gmail.com', 'Hóc Môn', '202cb962ac59075b964b07152d234b70', NULL, NULL, '0768893544'),
(27, 'Đinh Phúc Thịnh', 'thinhgpt1706@gmail.com', '536 Au Co', '7ca4100f078350295c611e78355a57d4', NULL, NULL, '0931816175'),
(32, 'Trần Đăng Phát', 'phattran280704@outlook.com', 'TP.HCM', '3b75b13a28364258df1f9f7cddb7b2f5', NULL, NULL, '0937024435'),
(33, 'Minh Vương', 'nnt090904@gmail.com', 'Hóc Môn', '69e4756805ff0abf358e132aeb6ab5ca', NULL, NULL, '0768893544'),
(34, 'dang the vinh', 'capijim747@gmail.com', 'ádfasdfasdfasdfsa', 'd6eb8d33b00b06ea903b4c170b167487', NULL, NULL, '0359855353'),
(36, 'Đinh Phúc Thịnh', 'zaikaman123@gmail.com', '536 Au Co', 'dc9417f67e802695ecb86dab88899c6d', NULL, NULL, '0931816175'),
(38, 'Đinh Phúc Thịnh', 'subthinh18@gmail.com', '536 Au Co', 'ce9642a7df00bb973f5d9c55d5f67c49', NULL, NULL, '0931816175');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dangky_temp`
--

CREATE TABLE `tbl_dangky_temp` (
  `id` int(11) NOT NULL,
  `ten_khachhang` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dien_thoai` varchar(50) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `dia_chi` text DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmucqa`
--

CREATE TABLE `tbl_danhmucqa` (
  `id_dm` int(11) NOT NULL,
  `name_sp` varchar(100) NOT NULL,
  `thu_tu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_danhmucqa`
--

INSERT INTO `tbl_danhmucqa` (`id_dm`, `name_sp`, `thu_tu`) VALUES
(52, 'Bóng rổ', 3),
(65, 'Bóng đá', 0),
(66, 'Bóng chuyền', 0),
(67, 'Cầu lông', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmuc_baiviet`
--

CREATE TABLE `tbl_danhmuc_baiviet` (
  `id_baiviet` int(11) NOT NULL,
  `tendanhmuc_baiviet` varchar(255) NOT NULL,
  `thutu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_danhmuc_baiviet`
--

INSERT INTO `tbl_danhmuc_baiviet` (`id_baiviet`, `tendanhmuc_baiviet`, `thutu`) VALUES
(0, 'CẦU LÔNG', 0),
(9, 'BÓNG RỔ', 0),
(14, 'BÓNG ĐÁ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giaohang`
--

CREATE TABLE `tbl_giaohang` (
  `id_shipping` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `note` varchar(200) DEFAULT NULL,
  `id_dangky` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_giaohang`
--

INSERT INTO `tbl_giaohang` (`id_shipping`, `name`, `phone`, `address`, `note`, `id_dangky`) VALUES
(1, 'Nguyễn Ngọc Tuấn', '0768893544', 'xã Bà Điểm Hóc Môn', '', 14),
(2, 'h', 'h', 'h', '', 25),
(3, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '123123', 16),
(4, 'Thinh Dinh', '93181617', '536/43/68A Âu Cơ', '123', 26),
(5, 'Thinh Dinh', '0931816175', '536 Au Co', '', 27),
(6, 'Trần Đăng Phát', '0779792312', 'Đồng Nai', '', 0),
(7, 'Trần Đăng Phát', '0779792132', 'Đồng Nai', '', 32),
(8, 'Minh Vương', '0768893544', 'Trường Đại học Sài Gòn', '', 33),
(9, 'Thinh Dinh', '0931816175', '536/43/68A Âu Cơ', '', 36);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giohangtam`
--

CREATE TABLE `tbl_giohangtam` (
  `id` int(11) NOT NULL,
  `id_khachhang` varchar(20) NOT NULL,
  `id_sanpham` varchar(20) NOT NULL,
  `so_luong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_giohangtam`
--

INSERT INTO `tbl_giohangtam` (`id`, `id_khachhang`, `id_sanpham`, `so_luong`) VALUES
(14, '', '136', 2),
(15, '', '131', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hoadon`
--

CREATE TABLE `tbl_hoadon` (
  `id_gh` int(11) NOT NULL,
  `id_khachhang` int(11) NOT NULL,
  `ma_gh` varchar(100) NOT NULL,
  `cart_date` varchar(100) NOT NULL,
  `cart_payment` varchar(50) NOT NULL,
  `cart_shipping` int(11) NOT NULL,
  `trang_thai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_hoadon`
--

INSERT INTO `tbl_hoadon` (`id_gh`, `id_khachhang`, `ma_gh`, `cart_date`, `cart_payment`, `cart_shipping`, `trang_thai`) VALUES
(119, 27, '674bdcce68b6a', '2024-12-01 10:49:34', 'tienmat', 5, 0),
(120, 27, '674bdcfe92da9', '2024-12-01 10:50:22', 'tienmat', 5, 0),
(121, 27, '674bdd277d116', '2024-12-01 10:51:03', 'tienmat', 5, 0),
(124, 27, '674bde81f1c4f', '2024-12-01 10:56:49', 'chuyenkhoan', 5, 0),
(125, 34, '674be6ac478ea', '2024-12-01 11:31:40', 'tienmat', 0, 0),
(126, 33, '674be8a702a18', '2024-12-01 11:40:07', 'tienmat', 8, 0),
(127, 33, '2769', '2024-12-01 11:47:33', 'tienmat', 8, 0),
(128, 33, '4457', '2024-12-01 11:57:59', 'vnpay', 8, 0),
(130, 33, '674bf0628551d', '2024-12-01 12:13:06', 'tienmat', 8, 0),
(132, 33, '2321', '2024-12-01 12:16:20', 'vnpay', 8, 0),
(133, 33, '7228', '2024-12-01 12:31:07', 'vnpay', 8, 0),
(134, 32, '5955', '2024-12-01 13:12:08', 'vnpay', 7, 0),
(135, 0, '214', '2024-12-01 13:18:02', 'vnpay', 6, 0),
(136, 0, '4756', '2024-12-01 13:24:09', 'momo', 6, 0),
(137, 0, '945', '2024-12-01 13:27:32', 'momo', 6, 0),
(138, 27, '674c077e9976a', '2024-12-01 13:51:42', 'tienmat', 5, 0),
(139, 33, '674c2ee4c9070', '2024-12-01 16:39:48', 'tienmat', 8, 0),
(140, 33, '674c2efbc25c4', '2024-12-01 16:40:11', 'tienmat', 8, 0),
(141, 33, '7511', '2024-12-01 17:13:12', 'momo', 8, 1),
(142, 33, '674c38c81a9b2', '2024-12-01 17:22:00', 'tienmat', 8, 0),
(143, 33, '674c3952ac6a8', '2024-12-01 17:24:18', 'tienmat', 8, 1),
(144, 14, '9683', '2024-12-01 17:28:33', 'vnpay', 1, 1),
(145, 14, '674c3a6d2a95f', '2024-12-01 17:29:01', 'tienmat', 1, 1),
(146, 14, '674c3a989d199', '2024-12-01 17:29:44', 'tienmat', 1, 1),
(147, 27, '674c3a9f7cd07', '2024-12-01 17:29:51', 'tienmat', 5, 1),
(148, 27, '674c3c95d3aab', '2024-12-01 17:38:13', 'tienmat', 5, 1),
(149, 27, '674c3fd0e0d96', '2024-12-01 17:52:00', 'tienmat', 5, 1),
(150, 27, '674c41589e279', '2024-12-01 17:58:32', 'tienmat', 5, 1),
(151, 27, '674c56a51a56f', '2024-12-01 19:29:25', 'tienmat', 5, 1),
(152, 27, '674c57b6c851b', '2024-12-01 19:33:58', 'tienmat', 5, 1),
(153, 27, '674c57ea8e53c', '2024-12-01 19:34:50', 'tienmat', 5, 1),
(154, 27, '674c58205f123', '2024-12-01 19:35:44', 'tienmat', 5, 1),
(155, 27, '674c585775003', '2024-12-01 19:36:39', 'tienmat', 5, 1),
(156, 27, '674c594ee2732', '2024-12-01 19:40:46', 'tienmat', 5, 1),
(157, 27, '674c598515f16', '2024-12-01 19:41:41', 'tienmat', 5, 1),
(158, 27, '674c59b8d2401', '2024-12-01 19:42:32', 'tienmat', 5, 1),
(159, 32, '636', '2024-12-01 19:43:12', 'vnpay', 7, 1),
(160, 27, '674c59eca1f9f', '2024-12-01 19:43:24', 'tienmat', 5, 1),
(161, 27, '674c5a1f34d06', '2024-12-01 19:44:15', 'tienmat', 5, 1),
(162, 32, '890', '2024-12-01 19:44:18', 'vnpay', 7, 1),
(163, 27, '674c5a5d05930', '2024-12-01 19:45:17', 'tienmat', 5, 1),
(164, 32, '8704', '2024-12-01 19:45:25', 'vnpay', 7, 1),
(165, 27, '674c5a8b9e3a2', '2024-12-01 19:46:03', 'tienmat', 5, 1),
(166, 32, '4192', '2024-12-01 19:46:25', 'vnpay', 7, 1),
(167, 32, '3557', '2024-12-01 19:47:20', 'vnpay', 7, 1),
(168, 27, '674c5ae9e854b', '2024-12-01 19:47:37', 'tienmat', 5, 1),
(169, 32, '1214', '2024-12-01 19:48:04', 'vnpay', 7, 1),
(170, 27, '674c5b27ddf1b', '2024-12-01 19:48:39', 'tienmat', 5, 1),
(171, 32, '8786', '2024-12-01 19:49:01', 'vnpay', 7, 1),
(172, 32, '7605', '2024-12-01 19:49:48', 'vnpay', 7, 1),
(173, 27, '674c5b7ab0578', '2024-12-01 19:50:02', 'tienmat', 5, 1),
(174, 32, '802', '2024-12-01 19:50:54', 'vnpay', 7, 1),
(175, 27, '674c5bdd3d5f2', '2024-12-01 19:51:41', 'tienmat', 5, 1),
(176, 32, '74', '2024-12-01 19:51:49', 'vnpay', 7, 1),
(177, 32, '8810', '2024-12-01 19:53:07', 'vnpay', 7, 1),
(178, 27, '674c5c361194f', '2024-12-01 19:53:10', 'tienmat', 5, 1),
(179, 32, '1547', '2024-12-01 19:53:41', 'vnpay', 7, 1),
(180, 32, '4800', '2024-12-01 19:54:35', 'vnpay', 7, 1),
(181, 27, '674c5c8feda00', '2024-12-01 19:54:39', 'tienmat', 5, 1),
(182, 32, '4154', '2024-12-01 19:55:17', 'vnpay', 7, 1),
(183, 32, '5462', '2024-12-01 19:56:06', 'vnpay', 7, 1),
(184, 32, '1238', '2024-12-01 19:57:48', 'momo', 7, 1),
(185, 32, '8915', '2024-12-01 19:59:23', 'momo', 7, 1),
(186, 32, '1083', '2024-12-01 20:00:47', 'momo', 7, 1),
(187, 32, '3610', '2024-12-01 20:01:56', 'momo', 7, 1),
(188, 32, '2948', '2024-12-01 20:03:37', 'momo', 7, 1),
(189, 32, '6538', '2024-12-01 20:04:44', 'momo', 7, 1),
(190, 32, '438', '2024-12-01 20:05:49', 'momo', 7, 1),
(191, 32, '4723', '2024-12-01 20:06:55', 'momo', 7, 1),
(192, 32, '9424', '2024-12-01 20:08:56', 'momo', 7, 1),
(193, 32, '4597', '2024-12-01 20:10:05', 'momo', 7, 1),
(194, 32, '9620', '2024-12-01 20:11:19', 'momo', 7, 1),
(195, 32, '4746', '2024-12-01 20:12:57', 'momo', 7, 1),
(196, 32, '2851', '2024-12-01 20:15:03', 'momo', 7, 1),
(197, 32, '8314', '2024-12-01 20:15:59', 'momo', 7, 1),
(198, 32, '1708', '2024-12-01 20:17:10', 'momo', 7, 1),
(199, 27, '674c633024694', '2024-12-01 20:22:56', 'tienmat', 5, 1),
(200, 27, '674c636329b39', '2024-12-01 20:23:47', 'tienmat', 5, 1),
(201, 27, '674c6398a17f2', '2024-12-01 20:24:40', 'tienmat', 5, 0),
(202, 27, '674c63cb03836', '2024-12-01 20:25:31', 'tienmat', 5, 1),
(204, 27, '674c6440cc0b3', '2024-12-01 20:27:28', 'tienmat', 5, 0),
(222, 36, '68c125f6a3aa1', '2025-09-10 14:17:10', 'tienmat', 9, 0),
(223, 36, '1757507613', '2025-09-10 19:35:02', 'momo', 9, 0),
(224, 36, '68c40966246ad', '2025-09-12 18:52:10', 'tienmat', 9, 1),
(225, 36, '68c82da16256e', '2025-09-15 22:15:45', 'tienmat', 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lienhe`
--

CREATE TABLE `tbl_lienhe` (
  `id` int(11) NOT NULL,
  `thongtinlienhe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_lienhe`
--

INSERT INTO `tbl_lienhe` (`id`, `thongtinlienhe`) VALUES
(1, 'Thông Tin Liên Hệ 7TCC<br><br>\r\n\r\nCửa Hàng Chính<br>\r\n- Địa chỉ: 273 An Dương Vương, Phường 3, Quận 5, TP.HCM<br>\r\n- Điện thoại: 0938688079<br>\r\n- Email: support@7tcc.vn<br>\r\n- Giờ làm việc: 8:00 - 22:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nBộ Phận Hỗ Trợ Khách Hàng<br>\r\n- Tổng đài hỗ trợ: 0909888888 (Miễn phí cuộc gọi)<br>\r\n- Email hỗ trợ: cskh@7tcc.vn<br>\r\n- Thời gian hỗ trợ: 8:00 - 21:00 (Tất cả các ngày trong tuần)<br><br>\r\n\r\nChính Sách & Quy Định<br>\r\n- Chúng tôi cam kết phản hồi mọi thắc mắc của quý khách trong vòng 24 giờ làm việc<br>\r\n- Mọi yêu cầu hỗ trợ sẽ được xử lý theo thứ tự ưu tiên<br>\r\n- Đối với các vấn đề khẩn cấp, vui lòng liên hệ trực tiếp qua tổng đài hỗ trợ<br><br>\r\n\r\nKết Nối Với Chúng Tôi<br>\r\n- Facebook: facebook.com/7tcc.vn<br>\r\n- Instagram: instagram.com/7tcc.vn<br>\r\n- Zalo: zalo.me/7tcc<br><br>\r\n\r\nRất hân hạnh được phục vụ quý khách!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_momo`
--

CREATE TABLE `tbl_momo` (
  `id_momo` int(11) NOT NULL,
  `partner_code` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `order_info` varchar(100) DEFAULT NULL,
  `order_type` varchar(50) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  `code_cart` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_momo`
--

INSERT INTO `tbl_momo` (`id_momo`, `partner_code`, `order_id`, `amount`, `order_info`, `order_type`, `trans_id`, `pay_type`, `code_cart`) VALUES
(1, 'MOMOBKUN20180529', 1730967443, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '9170'),
(2, 'MOMOBKUN20180529', 1733025351, '2190000', 'Thanh toán qua mã QR MoMo', 'momo_wallet', 2147483647, '', '2885'),
(3, 'MOMOBKUN20180529', 1733029455, '360000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '8630'),
(4, 'MOMOBKUN20180529', 1733030049, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '7975'),
(5, 'MOMOBKUN20180529', 1733033937, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1419'),
(6, 'MOMOBKUN20180529', 1733034371, '420000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6455'),
(7, 'MOMOBKUN20180529', 1733047929, '250000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6824'),
(8, 'MOMOBKUN20180529', 1733057813, '450000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6331'),
(9, 'MOMOBKUN20180529', 1733057921, '370000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6221'),
(10, 'MOMOBKUN20180529', 1733058007, '450000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '8939'),
(11, 'MOMOBKUN20180529', 1733058085, '349000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '4826'),
(12, 'MOMOBKUN20180529', 1733058147, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6607'),
(13, 'MOMOBKUN20180529', 1733058238, '360000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '375'),
(14, 'MOMOBKUN20180529', 1733058304, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '7740'),
(15, 'MOMOBKUN20180529', 1733058376, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6513'),
(16, 'MOMOBKUN20180529', 1733058472, '390000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '2994'),
(17, 'MOMOBKUN20180529', 1733058571, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '5411'),
(18, 'MOMOBKUN20180529', 1733058636, '300000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '7220'),
(19, 'MOMOBKUN20180529', 1733058720, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '2543'),
(20, 'MOMOBKUN20180529', 1733058840, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '2540'),
(21, 'MOMOBKUN20180529', 1733058920, '350000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '4565'),
(22, 'MOMOBKUN20180529', 1733058987, '450000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '6922'),
(23, 'MOMOBKUN20180529', 1757482356, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1181'),
(24, 'MOMOBKUN20180529', 1757482720, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '2327'),
(25, 'MOMOBKUN20180529', 1757483270, '200000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757483270'),
(26, 'MOMOBKUN20180529', 1757483675, '800000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757483675'),
(27, 'MOMOBKUN20180529', 1757483976, '1200000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757483976'),
(28, 'MOMOBKUN20180529', 1757484202, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757484202'),
(29, 'MOMOBKUN20180529', 1757484202, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757484202'),
(30, 'MOMOBKUN20180529', 1757484374, '400000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757484374'),
(31, 'MOMOBKUN20180529', 1757507613, '1200000', 'Thanh toán qua MoMo ATM', 'momo_wallet', 2147483647, 'napas', '1757507613');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `id_sp` int(11) NOT NULL,
  `ten_sp` varchar(200) NOT NULL,
  `ma_sp` varchar(100) NOT NULL,
  `gia_sp` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `so_luong_con_lai` int(11) NOT NULL,
  `hinh_anh` varchar(50) NOT NULL,
  `tom_tat` text DEFAULT NULL,
  `noi_dung` longtext DEFAULT NULL,
  `id_dm` int(11) NOT NULL,
  `tinh_trang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`id_sp`, `ten_sp`, `ma_sp`, `gia_sp`, `so_luong`, `so_luong_con_lai`, `hinh_anh`, `tom_tat`, `noi_dung`, `id_dm`, `tinh_trang`) VALUES
(140, 'Áo Sân Nhà Manchester City 2023 2024', 'MCIH2324', 350000, 100, 100, 'mci2324.png', 'Áo Manchester City Sân Nhà Mùa 2023/24\\r\\n\\r\\nKỷ niệm 20 năm tại sân Etihad, áo Manchester City mùa 2023/24 được thiết kế với họa tiết nổi bật từ sân Etihad và vích cổ trắng. Áo sử dụng chất liệu dryCELL thoáng mát và có logo câu lạc bộ cùng logo PUMA. Mua áo chính thức để nhận được chất lượng cao và đóng góp cho chương trình từ thiện City in the Community.', 'Dưới đây là nội dung được chỉnh sửa để loại bỏ các ký tự không cần thiết và đảm bảo dễ đọc hơn:\\r\\n\\r\\nÁo Manchester City Sân Nhà Mùa 2023/24\\r\\nChúng tôi kỷ niệm 20 năm Manchester City tại sân Etihad với áo sân nhà mùa 2023/24. Áo này được thiết kế nhằm tôn vinh các chi tiết nổi bật của sân và gợi nhớ đến áo sân đầu tiên được mặc trong mùa giải đầu tiên tại Etihad.\\r\\n\\r\\nĐặc điểm nổi bật:\\r\\nHọa tiết trên áo: Áo được trang trí với các họa tiết tôn lên kiến trúc đặc trưng của sân Etihad, bao gồm các khối tượng lớn bên ngoài sân.\\r\\nViền cổ: Viền cổ trắng, lấy cảm hứng từ thiết kế áo sân mùa giải đầu tiên tại Etihad.\\r\\nLogo: Logo câu lạc bộ và logo PUMA Cat được đặt trên ngực và cả hai tay áo.\\r\\nChất liệu: Sử dụng công nghệ dryCELL, giúp thấm hút mồ hôi và giữ cơ thể luôn mát mẻ trong suốt quá trình tập luyện.\\r\\nNội dung in: Chữ \\\"CITY\\\" được khắc ở cổ tay sau, kèm theo hình ảnh sân Etihad in bên trong cổ áo.\\r\\nLý do mua:\\r\\nKỷ niệm đặc biệt: Đánh dấu 20 năm Manchester City thi đấu tại sân Etihad.\\r\\nChất lượng cao: Áo chính thức, được thiết kế với công nghệ hiện đại và độ bền cao.\\r\\nĐóng góp xã hội: Mỗi chiếc áo bán ra sẽ đóng góp £5 cho chương trình City in the Community, hỗ trợ cải thiện cuộc sống của thanh niên thông qua bóng đá.', 65, 1),
(141, 'Áo Sân Khách Manchester City 2023 2024', 'MCIA2324', 350000, 100, 100, 'mcia2324.jpg', 'Áo Manchester City Sân Khách Mùa 2023/24\\r\\n\\r\\nThiết kế độc đáo và phong cách với màu sắc và họa tiết mới mẻ. Áo sử dụng công nghệ dryCELL tiên tiến, thấm hút mồ hôi và giữ cơ thể khô ráo. Logo câu lạc bộ và logo PUMA đảm bảo chất lượng và tính xác thực. Phù hợp cho cả việc cổ vũ đội bóng và sử dụng hàng ngày.', 'Dưới đây là nội dung đã được chỉnh sửa để loại bỏ các ký tự không cần thiết và đảm bảo dễ đọc hơn:\\r\\n\\r\\nÁo Manchester City Sân Khách Mùa 2023/24\\r\\nKhám phá sự độc đáo và phong cách với áo Manchester City sân khách mùa 2023/24. Áo này không chỉ thể hiện tình yêu và sự ủng hộ cho đội bóng mà còn mang đến sự thoải mái và thời trang đỉnh cao.\\r\\n\\r\\nĐặc điểm nổi bật:\\r\\nThiết kế: Áo có màu sắc và họa tiết đặc biệt, khác biệt hoàn toàn so với áo sân nhà, mang lại vẻ ngoài mới mẻ và hiện đại.\\r\\nChất liệu: Sử dụng công nghệ dryCELL tiên tiến, giúp thấm hút mồ hôi và giữ cơ thể luôn khô ráo.\\r\\nLogo: Trang bị logo câu lạc bộ và logo PUMA Cat trên ngực và tay áo, đảm bảo chất lượng và tính xác thực.\\r\\nCổ áo và tay áo: Thiết kế tinh tế, tạo điểm nhấn phong cách và hiện đại.\\r\\nLý do mua:\\r\\nPhong cách độc đáo: Áo sân khách mang lại vẻ ngoài khác biệt, vừa thời trang vừa phù hợp cho việc cổ vũ đội bóng hoặc sử dụng hàng ngày.\\r\\nChất lượng vượt trội: Sản phẩm chính hãng, được sản xuất bởi PUMA với chất lượng đảm bảo.\\r\\nTiện ích và thoải mái: Thiết kế và chất liệu đảm bảo sự thoải mái trong mọi hoạt động.', 65, 1),
(142, 'Áo Thứ Ba Manchester City 2023 2024', 'MCIT2324', 350000, 100, 99, 'mcit2324.jpg', 'Áo Thứ Ba Manchester City Mùa 2023/24\\r\\n\\r\\nThiết kế độc đáo và phong cách với màu sắc và họa tiết mới mẻ. Áo sử dụng công nghệ dryCELL tiên tiến, thấm hút mồ hôi và giữ cơ thể khô ráo. Logo câu lạc bộ và logo PUMA đảm bảo chất lượng và tính xác thực. Phù hợp cho cả việc cổ vũ đội bóng và sử dụng hàng ngày.', 'Áo Thứ Ba Manchester City Mùa 2023/24\\r\\n\\r\\nKhám phá sự độc đáo và phong cách với áo thứ ba Manchester City mùa 2023/24. Áo này không chỉ thể hiện tình yêu và sự ủng hộ cho đội bóng mà còn mang đến sự thoải mái và thời trang đỉnh cao.\\r\\n\\r\\nĐặc điểm nổi bật:\\r\\nThiết kế: Áo có màu sắc và họa tiết đặc biệt, khác biệt so với áo sân nhà và áo sân khách, mang lại vẻ ngoài mới mẻ và hiện đại.\\r\\nChất liệu: Sử dụng công nghệ dryCELL tiên tiến, giúp thấm hút mồ hôi và giữ cơ thể luôn khô ráo.\\r\\nLogo: Được trang bị logo câu lạc bộ và logo PUMA Cat trên ngực và tay áo, đảm bảo chất lượng và tính xác thực.\\r\\nCổ áo và tay áo: Thiết kế tinh tế, tạo điểm nhấn phong cách.\\r\\nLý do mua:\\r\\nPhong cách độc đáo: Áo thứ ba mang lại vẻ ngoài khác biệt, phù hợp cả khi cổ vũ đội bóng lẫn sử dụng hàng ngày.\\r\\nChất lượng vượt trội: Sản phẩm chính hãng, đảm bảo chất lượng từ PUMA và Manchester City.\\r\\nTiện ích và thoải mái: Chất liệu và thiết kế mang đến sự thoải mái trong mọi hoạt động.', 65, 1),
(143, 'Áo Sân Nhà Liverpool mùa 2024 2025', 'LIVH2425', 350000, 100, 100, 'LIVH2324.jpg', 'Áo Sân Nhà Liverpool Mùa 2024/25\\r\\n\\r\\nThiết kế độc đáo và phong cách với màu sắc và họa tiết mới mẻ. Áo sử dụng công nghệ Dri-Fit ADV tiên tiến, thấm hút mồ hôi và giữ cơ thể khô ráo. Logo câu lạc bộ và logo Nike đảm bảo chất lượng và tính xác thực. Phù hợp cho cả việc cổ vũ đội bóng và sử dụng hàng ngày.', 'Áo Sân Nhà Liverpool Mùa 2024/25\\r\\nKhám phá sự độc đáo và phong cách với áo sân nhà Liverpool mùa 2024/25. Áo này không chỉ thể hiện tình yêu và sự ủng hộ cho đội bóng mà còn mang đến sự thoải mái và thời trang đỉnh cao.\\r\\n\\r\\nĐặc điểm nổi bật:\\r\\nThiết kế: Áo có màu sắc và họa tiết đặc biệt, mang lại vẻ ngoài mới mẻ và hiện đại.\\r\\nChất liệu: Sử dụng công nghệ Dri-Fit ADV tiên tiến, giúp thấm hút mồ hôi và giữ cơ thể luôn khô ráo.\\r\\nLogo: Được trang bị logo câu lạc bộ và logo Nike trên ngực và tay áo, đảm bảo chất lượng và tính xác thực.\\r\\nCổ áo và tay áo: Thiết kế tinh tế, tạo điểm nhấn phong cách.\\r\\nLý do mua:\\r\\nPhong cách độc đáo: Áo sân nhà mang lại vẻ ngoài khác biệt, phù hợp cả khi cổ vũ đội bóng lẫn sử dụng hàng ngày.\\r\\nChất lượng vượt trội: Sản phẩm chính hãng, đảm bảo chất lượng từ Nike và Liverpool.\\r\\nTiện ích và thoải mái: Chất liệu và thiết kế mang đến sự thoải mái trong mọi hoạt động.', 65, 1),
(144, 'Áo Sân Nhà Chelsea 2024 2025', 'CHEH2425', 350000, 100, 100, 'CHEH2425.jpg', 'Áo Sân Nhà Chelsea Mùa 2024/25\\r\\n\\r\\nThiết kế độc đáo và phong cách với màu sắc và họa tiết mới mẻ. Áo sử dụng công nghệ AeroSwift tiên tiến, thấm hút mồ hôi và giữ cơ thể khô ráo. Logo câu lạc bộ và logo Nike đảm bảo chất lượng và tính xác thực. Phù hợp cho cả việc cổ vũ đội bóng và sử dụng hàng ngày.', 'Áo Sân Nhà Chelsea Mùa 2024/25\\r\\n\\r\\nHòa nhịp cùng niềm đam mê và phong cách với áo sân nhà Chelsea mùa 2024/25. Áo này không chỉ thể hiện tình yêu và sự ủng hộ mãnh liệt cho đội bóng mà còn mang đến sự thoải mái và thời trang đỉnh cao.\\r\\n\\r\\nĐặc điểm nổi bật:\\r\\n\\r\\nThiết kế: Áo có thiết kế màu xanh truyền thống của Chelsea, kết hợp với các chi tiết và họa tiết hiện đại, tạo nên vẻ ngoài mới mẻ và thu hút.\\r\\nChất liệu: Sử dụng công nghệ AeroSwift tiên tiến, giúp thấm hút mồ hôi và giữ cơ thể luôn khô ráo, thoải mái suốt cả ngày.\\r\\nLogo: Được trang bị logo câu lạc bộ Chelsea và logo Nike trên ngực và tay áo, đảm bảo chất lượng và tính xác thực.\\r\\nCổ áo và tay áo: Thiết kế cổ áo và tay áo tạo điểm nhấn tinh tế và phong cách độc đáo.\\r\\nLý do mua:\\r\\n\\r\\nPhong cách đậm chất Chelsea: Áo sân nhà mang lại vẻ ngoài thể thao và thời trang, phù hợp cho cả việc cổ vũ đội bóng và sử dụng hàng ngày.\\r\\nChất lượng vượt trội: Sản phẩm chính hãng, đảm bảo chất lượng từ Nike và Chelsea.\\r\\nTiện ích và thoải mái: Chất liệu và thiết kế đảm bảo sự thoải mái trong mọi hoạt động, từ cổ vũ trên sân vận động đến các hoạt động thể thao hàng ngày.', 65, 1),
(150, 'Áo Sân Nhà Manchester United 2024 2025', 'MNUH2425', 350000, 200, 199, 'MNUH2425.png', 'Áo đấu nhà Manchester United mùa 2024-2025 được thiết kế bởi adidas và ra mắt vào ngày 1 tháng 7 năm 2024. Thiết kế áo này tạo ấn tượng mạnh mẽ với sự kết hợp của hai màu đỏ, từ đỏ nhạt đến đỏ sẫm, tạo hiệu ứng ánh sáng độc đáo khi ánh sáng Old Trafford chiếu lên. Áo đấu này có thêm một khối màu đỏ rực rỡ trên tay áo và quần, tạo thành một đường kết nối đặc biệt.', 'Thiết kế và màu sắc:\\n\\nMàu chính: Áo đấu có hai màu đỏ, từ đỏ nhạt đến đỏ sẫm, tạo hiệu ứng ánh sáng độc đáo.\\n\\nKhối đỏ rực rỡ: Một khối màu đỏ rực rỡ trên tay áo và quần, tạo thành một đường kết nối đặc biệt.\\n\\nCổ áo: Áo có cổ áo crew neck và logo adidas ba dòng trên vai.\\n\\nLogo và đối tác chính: Logo của đối tác chính Snapdragon và logo adidas đều có màu trắng tạo sự tương phản.\\n\\nChất liệu và công nghệ:\\n\\nChất liệu: Áo đấu được làm từ vật liệu tái chế, giúp giảm thiểu rác thải và tài nguyên hạn chế.\\n\\nCông nghệ: Áo đấu có công nghệ HEAT.RDY giúp tối ưu hóa luồng mây để giữ cơ thể cảm thấy mát mẻ, và công nghệ AEROREADY giúp bớt mồ hôi và giữ cơ thể khô ráo', 65, 1),
(151, 'Áo Sân Nhà Manchester City 2024 2025', 'MCIH2425', 350000, 150, 149, 'MCIH2425.jpg', 'Áo đấu nhà Manchester City mùa 2024-2025 được thiết kế bởi PUMA và ra mắt vào ngày 16 tháng 5 năm 2024. Thiết kế áo này tạo ấn tượng mạnh mẽ với màu xanh dương bầu trời, kết hợp với các sợi chỉ \\\"0161\\\" trên tay áo và cổ tay, đại diện cho mã số điện thoại của Manchester. Áo đấu này không chỉ tạo sự tương phản mà còn thể hiện sự tự hào Citizens', 'Thiết kế và màu sắc:\\n\\nMàu chính: Áo đấu có màu xanh dương bầu trời, tạo sự tương phản với các sợi chỉ \\\"0161\\\" trên tay áo và cổ tay.\\n\\nSợi chỉ \\\"0161\\\": Sự kết hợp của mã số điện thoại của Manchester, tạo ra sự đặc biệt và gắn kết với cội nguồn Mancunian.\\n\\nCổ áo: Áo có cổ áo crew neck và logo PUMA ba dòng trên vai.\\n\\nLogo và đối tác chính: Logo của đối tác chính và logo PUMA đều có màu trắng tạo sự tương phản.\\n\\nChất liệu và công nghệ:\\n\\nChất liệu: Áo đấu được làm từ vật liệu tái chế, giúp giảm thiểu rác thải và tài nguyên hạn chế.\\n\\nCông nghệ: Áo đấu có công nghệ dry-CELL giúp bớt mồ hôi và giữ cơ thể khô ráo, và công nghệ RE:FIBRE giúp giảm trọng lượng và ma sát, tối ưu hóa hiệu suất cao cấp', 65, 1),
(152, 'Áo Sân Nhà Barcelona 2024 2025', 'BARH2425', 300000, 150, 150, 'BARH2425.jpg', 'Áo đấu nhà FC Barcelona mùa 2024-2025 được thiết kế bởi Nike và ra mắt vào ngày 18 tháng 7 năm 2024. Thiết kế áo này tạo ấn tượng mạnh mẽ với các sọc đỏ và xanh dương truyền thống, nhưng với một chút biến đổi hiện đại. Áo đấu này không chỉ thể hiện sự tự hào về lịch sử của câu lạc bộ mà còn mang đến sự độc đáo và đặc biệt.', 'Thiết kế và màu sắc:\\n\\nMàu chính: Áo đấu có các sọc đỏ và xanh dương truyền thống, nhưng với hiệu ứng biến đổi từ màu đỏ sang xanh dương tại phần giữa áo, tạo ra một vẻ đẹp độc đáo.\\n\\nCổ áo: Áo có cổ áo crew neck và logo Nike ba dòng trên vai.\\n\\nLogo và đối tác chính: Logo của đối tác chính và logo Nike đều có màu vàng, tạo sự tương phản với các sọc đỏ và xanh dương.\\n\\nChất liệu và công nghệ:\\n\\nChất liệu: Áo đấu được làm từ vật liệu tái chế, giúp giảm thiểu rác thải và tài nguyên hạn chế.\\n\\nCông nghệ: Áo đấu có công nghệ Dri-FIT giúp bớt mồ hôi và giữ cơ thể khô ráo, và công nghệ RE:FIBRE giúp giảm trọng lượng và ma sát, tối ưu hóa hiệu suất cao cấp.', 65, 1),
(153, 'Áo Sân Khách Barcelona 2024 2025', 'BARA2425', 350000, 175, 174, 'BARA2425.jpg', 'Áo đấu sân khách của FC Barcelona cho mùa 2024-2025 là một sự kỷ niệm đặc biệt đến 125 năm lịch sử của câu lạc bộ. Thiết kế áo này được lấy cảm hứng từ trang phục đầu tiên của Barça vào năm 1899, với màu sắc chính là đen. Áo đấu này không chỉ thể hiện sự đặc biệt và độc đáo mà còn mang lại sự tôn vinh cho nguồn gốc của câu lạc bộ.', 'Thiết kế: Áo đấu sân khách của mùa 2024-2025 có thiết kế đặc biệt với màu đen chính và các dải xanh và đỏ tạo thành vòng tròn trên nền đen, tạo ra sự tương phản mạnh mẽ và ấn tượng. Biểu tượng của Barça được in trên áo với màu đen, được bao quanh bởi các màu xanh và đỏ2.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ Dri-FIT ADV của Nike, cung cấp độ thoải mái, thở dễ dàng và giữ ấm tốt nhất cho cơ thể người chơi.\\n\\nLogo: Áo đấu sẽ có logo Spotify trên phía trước, cùng với logo Nike, và logo Ambilight TV trên tay áo của đội tuyển nam. Đối với đội tuyển nữ, logo Bimbo sẽ xuất hiện trên tay áo3.\\n\\nSản phẩm: Áo đấu sẽ có sẵn từ tháng 9 năm 2024 và có thể được mua tại các cửa hàng Barça và trực tuyến.', 65, 1),
(154, 'Áo Sân Nhà Arsenal 2024 2025', 'ARSH2425', 250000, 120, 120, 'ARSH2425.png', 'Áo đấu sân nhà của Arsenal cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu đỏ tươi, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có màu đỏ tươi chủ đạo, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Arsenal được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Adidas, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo Emirates Fly Better ở phía trước, cùng với logo Adidas.', 65, 1),
(155, 'Áo Sân Nhà Manchester United 2023 2024', 'MNUH2324', 250000, 100, 100, 'MNUH2324.jpg', 'Áo đấu sân nhà của Manchester United cho mùa giải 2023-2024 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu đỏ tươi, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2023-2024 có màu đỏ tươi chủ đạo, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Manchester United được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Adidas, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo Adidas trên phía trước, cùng với logo của câu lạc bộ.', 65, 1),
(156, 'Áo Sân Nhà Real Madrid 2024 2025', 'REAH2425', 299000, 100, 100, 'REAH2425.jpg', 'Áo đấu sân nhà của Real Madrid cho mùa giải 2024-2025 là một biểu tượng của sự thanh lịch và mạnh mẽ. Với màu trắng truyền thống, áo đấu mang đến cảm giác tinh tế nhưng vẫn không kém phần hiện đại. Thiết kế này tôn vinh lịch sử vĩ đại của câu lạc bộ, đồng thời truyền tải tinh thần đổi mới và năng động.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có màu trắng chủ đạo, kết hợp với các chi tiết màu xanh dương và đỏ trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Real Madrid được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Adidas, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo Fly Emirates trên phía trước, cùng với logo Adidas.', 65, 1),
(157, 'Áo Sân Nhà AC Milan 2024 2025', 'ACMH2425', 349000, 190, 189, 'ACMH2425.jpg', 'Áo đấu sân nhà của AC Milan cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu đỏ và đen, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có thiết kế đặc biệt với các dải đỏ và đen truyền thống, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ AC Milan được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Puma, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo Fly Emirates trên phía trước, cùng với logo Puma.', 65, 1),
(158, 'Áo Sân Nhà Inter Milan 2024 2025', 'INTH2425', 360000, 180, 180, 'INTH2425.jpg', 'Áo đấu sân nhà của Inter Milan cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu xanh đen, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có thiết kế đặc biệt với các dải xanh đen truyền thống, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Inter Milan được in ở ngực trái, biểu tượng rắn Biscione đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Nike, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo Betsson Sport trên phía trước, cùng với logo Nike.', 65, 1),
(159, 'Áo Sân Nhà Napoli 2024 2025', 'NAPH2425', 355000, 100, 100, 'NAPH2425.jpg', 'Áo đấu sân nhà của Napoli cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu xanh dương Napoli, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự trẻ trung, năng động cho đội bóng.', 'Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có thiết kế đặc biệt với các dải xanh dương truyền thống, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Napoli được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của EA7, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo MSC trên phía trước, cùng với logo EA7.', 65, 1),
(160, 'Áo Sân Khách Napoli 2024 2025', 'NAPA2425', 299000, 100, 99, 'NAPA2425.jpg', 'Áo đấu sân khách của Napoli cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là màu trắng, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự thanh lịch, tinh tế cho đội bóng.', 'Thiết kế: Áo đấu sân khách của mùa giải 2024-2025 có thiết kế đặc biệt với màu trắng chủ đạo, kết hợp với các chi tiết màu xanh dương và đỏ trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài thanh lịch nhưng không kém phần hiện đại. Logo của câu lạc bộ Napoli được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\n\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của EA7, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\n\\nLogo: Áo đấu sẽ có logo EA7 trên phía trước, cùng với logo của câu lạc bộ.', 65, 1),
(161, 'Áo Sân Nhà Bayern Munchen 2024 2025', 'BAYH2425', 350000, 180, 180, 'BAYH2425.jpg', 'Áo đấu sân nhà của Bayern Munich cho mùa giải 2024-2025 là một sự kết hợp hoàn hảo giữa truyền thống và hiện đại. Với thiết kế chủ đạo là ba màu đỏ khác nhau, áo đấu này không chỉ tôn vinh lịch sử lâu đời của câu lạc bộ mà còn mang lại sự động đậy và cảm xúc cho đội bóng.', '>Thiết kế: Áo đấu sân nhà của mùa giải 2024-2025 có thiết kế đặc biệt với ba màu đỏ khác nhau, kết hợp với các chi tiết màu trắng trên tay áo và cổ áo. Điều này tạo nên vẻ ngoài truyền thống nhưng không kém phần hiện đại. Logo của câu lạc bộ Bayern Munich được in ở ngực trái, biểu tượng pháo thủ đặc trưng của đội bóng.\\r\\n\\r\\nCông nghệ: Áo đấu được thiết kế với công nghệ tiên tiến của Adidas, giúp người chơi cảm thấy thoải mái, khô ráo và mát mẻ trong suốt quá trình thi đấu. Chất liệu vải nhẹ và thoáng khí, cùng với khả năng hút ẩm tốt, đảm bảo hiệu suất tối đa trên sân cỏ.\\r\\n\\r\\nLogo: Áo đấu sẽ có logo Allianz trên phía trước, cùng với logo Adidas.', 65, 1),
(162, 'Áo Sân Nhà Borrusia Dortmund 2024 2025', 'BVBH2425', 400000, 250, 249, 'BVBH2425.jpg', 'Áo đấu nhà mùa 2024-2025 của Borussia Dortmund mang thiết kế truyền thống và đầy thời hiện đại. Sản phẩm này có cổ tay đen và bốn sọc mỏng màu vàng trên áo. Phông chữ \\\"Dortmund\\\" đen rõ ràng trên lưng, cùng với khẩu hiệu \\\"Borussia verbindet\\\" (Borussia thống nhất) trên cổ tay. Áo đấu này được làm từ 95% polyester thải ra, góp phần bảo vệ môi trường.', 'Thiết kế: Áo đấu sân nhà mùa 2024-2025 của Borussia Dortmund mang đậm chất truyền thống với màu vàng chủ đạo. Cổ áo và cổ tay có màu đen tạo điểm nhấn tinh tế. Điểm đặc biệt là bốn sọc mỏng màu đen chạy dọc theo thân áo, tăng thêm tính thẩm mỹ và phong cách đặc trưng của đội bóng. Trên lưng áo có in chữ \\\"Dortmund\\\" màu đen rõ nét, cùng với khẩu hiệu \\\"Borussia verbindet\\\" (Borussia thống nhất) trên cổ tay, thể hiện tinh thần đoàn kết và gắn bó của câu lạc bộ.\\n\\nChất liệu: Áo đấu được làm từ 95% polyester tái chế, giúp bảo vệ môi trường và giảm thiểu rác thải. Chất liệu này không chỉ bền bỉ mà còn giúp thoáng khí, giữ cơ thể luôn khô ráo và thoải mái trong suốt quá trình vận động. Công nghệ dryCELL tích hợp trên áo giúp loại bỏ mồ hôi nhanh chóng, đảm bảo người mặc luôn cảm thấy thoải mái và tự tin.', 65, 1),
(163, 'Áo Sân Nhà Tottenham Hotspur 2024 2025', 'TOTH2425', 199000, 200, 199, 'TOTH2425.jpg', 'Áo đấu nhà mùa 2024-2025 của Tottenham Hotspur mang thiết kế truyền thống và hiện đại. Áo có màu trắng chủ đạo với cổ tay màu xanh dương, tạo sự tinh tế và đặc trưng cho đội bóng. Phông chữ \\\"Tottenham Hotspur\\\" màu đen rõ ràng trên lưng, cùng với khẩu hiệu \\\"To Dare Is To Do\\\" (Dũng cảm là hành động) trên cổ tay. Áo đấu này được làm từ 100% polyester tái chế, góp phần bảo vệ môi trường.', 'Thiết kế: Áo đấu nhà mùa 2024-2025 của Tottenham Hotspur có thiết kế truyền thống với màu trắng chủ đạo và cổ tay màu xanh dương. Phông chữ \\\"Tottenham Hotspur\\\" màu đen rõ ràng trên lưng, cùng với khẩu hiệu \\\"To Dare Is To Do\\\" (Dũng cảm là hành động) trên cổ tay.\\n\\nChất liệu: Áo đấu được làm từ 100% polyester tái chế, giúp bảo vệ môi trường và giảm thiểu rác thải. Chất liệu này không chỉ bền bỉ mà còn giúp thoáng khí, giữ cơ thể luôn khô ráo và thoải mái trong suốt quá trình vận động. Công nghệ Dri-FIT ADV tích hợp trên áo giúp loại bỏ mồ hôi nhanh chóng, đảm bảo người mặc luôn cảm thấy thoải mái và tự tin.', 65, 1),
(164, 'Áo Sân Nhà Newcastle United 2024 2025', 'NEWH2425', 300000, 150, 148, 'NEWH2425.jpg', 'Áo đấu nhà mùa 2024-2025 của Newcastle United mang thiết kế truyền thống và hiện đại. Áo có ba sọc đen rộng rãi trên thân áo, tạo điểm nhấn đặc trưng cho đội bóng. Phông chữ \\\"Newcastle United\\\" đen rõ ràng trên lưng, cùng với biểu tượng đội bóng trên cổ tay. Áo đấu này được làm từ 100% polyester tái chế, góp phần bảo vệ môi trường.', 'Thiết kế: Áo đấu nhà mùa 2024-2025 của Newcastle United có thiết kế truyền thống với ba sọc đen rộng rãi trên thân áo. Phông chữ \\\"Newcastle United\\\" đen rõ ràng trên lưng, cùng với biểu tượng đội bóng trên cổ tay.\\n\\nChất liệu: Áo đấu được làm từ 100% polyester tái chế, giúp bảo vệ môi trường và giảm thiểu rác thải. Chất liệu này không chỉ bền bỉ mà còn giúp thoáng khí, giữ cơ thể luôn khô ráo và thoải mái trong suốt quá trình vận động. Công nghệ HEAT.RDY tích hợp trên áo giúp loại bỏ mồ hôi nhanh chóng, đảm bảo người mặc luôn cảm thấy thoải mái và tự tin.', 65, 1),
(165, 'Áo Icon Golden State Warriors 2024', 'GSWI24', 350000, 100, 100, 'GSWI24.jpg', 'Áo đấu Golden State Warriors Icon 2024 là một phần quan trọng của dòng sản phẩm thể thao cao cấp, mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại và chất lượng cao. Thiết kế áo đấu này không chỉ thể hiện sự độc đáo và sáng tạo mà còn gắn kết với truyền thống và văn hóa của đội bóng.', 'Áo Đấu Golden State Warriors Icon 2024\\r\\nThiết kế độc đáo: Áo đấu Golden State Warriors Icon 2024 có thiết kế ấn tượng với viền màu và chữ viết \\\"Golden State\\\" trên áo và quần.\\r\\n\\r\\nChất liệu chất lượng cao: Sản phẩm được làm từ chất liệu cao cấp, mang lại độ bền cao và sự thoáng mát tối ưu.\\r\\n\\r\\nSự kết hợp với truyền thống: Thiết kế áo đấu này hòa quyện giữa phong cách hiện đại và giá trị truyền thống, gắn kết với văn hóa và lịch sử của San Francisco.\\r\\n\\r\\nSự độc đáo: Áo đấu nổi bật với viền màu đỏ cùng hình dạng cầu biểu tượng của San Francisco-Oakland Bay Bridge.', 52, 1),
(166, 'Áo Association Golden State Warriors 2024', 'GSWA24', 350000, 100, 100, 'GSWA24.jpg', 'Áo đấu Golden State Warriors Association 2024 là một phần quan trọng của dòng sản phẩm thể thao cao cấp, mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại và chất lượng cao. Thiết kế áo đấu này không chỉ thể hiện sự độc đáo và sáng tạo mà còn gắn kết với truyền thống và văn hóa của đội bóng.', 'Thiết kế độc đáo: Áo đấu Golden State Warriors Association 2024 có thiết kế độc đáo với viền màu và chữ viết bằng chữ \\\"Golden State\\\" trên áo và quần.\\n\\nChất liệu chất lượng cao: Sản phẩm được làm từ chất liệu cao cấp, đảm bảo độ bền và thoáng mát.\\n\\nSự kết hợp với truyền thống: Thiết kế áo đấu này kết hợp giữa sự hiện đại và truyền thống, gắn kết với văn hóa và lịch sử của San Francisco.\\n\\nSự độc đáo: Áo đấu có đặc điểm độc đáo với viền màu đỏ và hình dạng cầu biểu tượng của San Francisco-Oakland Bay Bridge.', 52, 1),
(167, 'Áo Icon Miami Heat 2024', 'HEAI24', 349000, 200, 200, 'HEAI24.jpg', 'Áo đấu Miami Heat Icon 2024 là một phần quan trọng của dòng sản phẩm thể thao cao cấp, mang đến sự kết hợp hoàn hảo giữa thiết kế hiện đại và chất lượng cao. Thiết kế áo đấu này không chỉ thể hiện sự độc đáo và sáng tạo mà còn gắn kết với truyền thống và văn hóa của đội bóng.', 'Thiết kế độc đáo: Áo đấu Miami Heat Icon 2024 có thiết kế độc đáo với viền màu và chữ viết bằng chữ \\\"Miami Heat\\\" trên áo và quần.\\n\\nChất liệu chất lượng cao: Sản phẩm được làm từ chất liệu cao cấp, đảm bảo độ bền và thoáng mát.\\n\\nSự kết hợp với truyền thống: Thiết kế áo đấu này kết hợp giữa sự hiện đại và truyền thống, gắn kết với văn hóa và lịch sử của Miami.\\n\\nSự độc đáo: Áo đấu có đặc điểm độc đáo với viền màu đỏ sáng và hình dạng cầu biểu tượng của Miami.', 52, 1),
(168, 'Áo Association Miami Heat 2024', 'HEAA24', 350000, 300, 300, 'HEAA24.jpg', 'Tóm tắt Áo Miami Heat Association 2024\\nMàu sắc chính: Đỏ cam\\n\\nThiết kế: Chữ và số trắng, viền đen\\n\\nChất liệu: Mềm mại, thoáng mát\\n\\nLogo và biểu tượng đặc biệt của Miami Heat', 'Áo Miami Heat Association 2024\\nMàu sắc chính: Đỏ cam (Blood Red), tượng trưng cho sự quyết tâm và sức mạnh của \\\"Heat Culture\\\".\\n\\nThiết kế đặc biệt: Áo có thiết kế độc đáo với chữ viết và số đếm trắng, được đậm hơn bởi đường viền đen.\\n\\nChất liệu: Chất liệu mềm mại, thoáng mát, rất thoải mái để mặc.\\n\\nĐặc điểm độc đáo: Áo mang logo và thiết kế đặc biệt của Miami Heat, thể hiện sự trang trọng và sự tự hào về đội.', 52, 1),
(169, 'Áo Icon Cleveland Cavaliers 2024', 'CAVI24', 350000, 100, 100, 'CAVI2024.jpg', 'Sản phẩm áo icon của Cleveland Cavaliers 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh nền văn hóa nghệ thuật của Cleveland. Áo này được truyền cảm hứng từ Bảo tàng Nghệ thuật Cleveland và có thiết kế độc đáo với các yếu tố như màu sắc, chữ viết, và hình ảnh nghệ thuật', 'Thiết kế màu sắc và hình ảnh: Áo có các màu sắc đặc trưng và hình ảnh nghệ thuật được lấy cảm hứng từ Bảo tàng Nghệ thuật Cleveland.\\n\\nCác yếu tố độc đáo: Áo có các đoạn bên cạnh được thiết kế như một cuốn sách vẽ, với các hình ảnh và biểu tượng nổi tiếng của Cleveland.\\n\\nChất liệu và công nghệ: Áo được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.\\n\\nSứ mệnh: Áo không chỉ là một món đồ thể thao mà còn là một tác phẩm nghệ thuật, kết hợp giữa thể thao và nghệ thuật để tôn vinh di sản văn hóa và thể thao của Cleveland.', 52, 1),
(170, 'Áo Association Cleveland Cavaliers 2024', 'CAVA24', 350000, 200, 199, 'CAVA24.jpg', 'Áo Association của Cleveland Cavaliers năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Cleveland Cavaliers. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Cleveland Cavaliers.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Cleveland Cavaliers, cùng với logo của Nike và Cleveland-Cliffs patch.', 52, 1),
(172, 'Áo Icon Los Angeles Laker 2024', 'LALI24', 350000, 200, 199, 'LALI24.png', 'Áo Icon của Los Angeles Lakers năm 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh và kết nối với người hâm mộ Lakers. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Các đặc điểm nổi bật của áo Icon 2024 bao gồm:\\n\\nThiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Lakers, bao gồm màu tím và vàng.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Los Angeles Lakers, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Lake Show\\\": Áo này lần đầu tiên có dòng chữ \\\"Lake Show\\\" trên áo, tôn vinh biệt danh của đội từ thời kỳ \\\"Showtime\\\".', 52, 1),
(173, 'Áo Association Los Angeles Lakers 2024', 'LALA24', 350000, 200, 200, 'LALA24.png', 'Áo Association của Los Angeles Lakers năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Lakers. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Lakers, bao gồm màu tím và vàng.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Los Angeles Lakers, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Lake Show\\\": Áo này lần đầu tiên có dòng chữ \\\"Lake Show\\\" trên áo, tôn vinh biệt danh của đội từ thời kỳ \\\"Showtime\\\".', 52, 1),
(174, 'Áo Icon Boston Celtics 2024', 'CELI24', 350000, 200, 200, 'CELI24.jpg', 'Áo Icon của Boston Celtics năm 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh và kết nối với người hâm mộ Celtics. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Celtics, bao gồm màu đen và màu xanh lá cây \\\"Action Green\\\".\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Boston Celtics, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Boston Strong\\\": Áo này có dòng chữ \\\"Boston Strong\\\" trên áo, tôn vinh sức mạnh và tinh thần của đội và thành phố Boston.', 52, 1),
(175, 'Áo Association Boston Celtics 2024', 'CELA24', 350000, 300, 300, 'CELA24.jpg', 'Áo Association của Boston Celtics năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Celtics. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Celtics, bao gồm màu đen và màu xanh lá cây \\\"Action Green\\\".\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Boston Celtics, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Boston Strong\\\": Áo này có dòng chữ \\\"Boston Strong\\\" trên áo, tôn vinh sức mạnh và tinh thần của đội và thành phố Boston.', 52, 1),
(176, 'Áo Icon Dallas Mavericks 2024', 'MAVI24', 350000, 200, 200, 'MAVI24.jpg', 'Áo Icon của Dallas Mavericks năm 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh và kết nối với người hâm mộ Mavericks. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Mavericks, bao gồm màu trắng và màu xanh dương.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Dallas Mavericks, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Trinity River Blues\\\": Áo này có dòng chữ \\\"Trinity River Blues\\\" trên áo, tôn vinh di sản âm nhạc Blues của Dallas/Fort Worth.', 52, 1),
(177, 'Áo Association Dallas Mavericks 2024', 'MAVA24', 350000, 200, 200, 'MAVA24.jpg', 'Áo Association của Dallas Mavericks năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Mavericks. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Mavericks, bao gồm màu trắng và màu xanh dương.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Dallas Mavericks, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Trinity River Blues\\\": Áo này có dòng chữ \\\"Trinity River Blues\\\" trên áo, tôn vinh di sản âm nhạc Blues của Dallas/Fort Worth.', 52, 1),
(178, 'Áo Icon Milwaukee Bucks 2024', 'BUCI24', 350000, 200, 200, 'BUCI24.jpg', 'Áo Icon của Milwaukee Bucks năm 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh và kết nối với người hâm mộ Bucks. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Bucks, bao gồm màu xanh dương (Great Lakes Blue) và màu trắng (Cream City Cream).\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Milwaukee Bucks, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Cream City\\\": Áo này có dòng chữ \\\"Cream City\\\" trên áo, tôn vinh di sản của Milwaukee với những gạch xà phòng trắng đặc trưng.', 52, 1),
(179, 'Áo Association Milwaukee Bucks 2024', 'BUCA24', 350000, 200, 200, 'BUCA24.jpg', 'Áo Association của Milwaukee Bucks năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Bucks. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Bucks, bao gồm màu xanh dương (Great Lakes Blue) và màu trắng (Cream City Cream).\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Milwaukee Bucks, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Cream City\\\": Áo này có dòng chữ \\\"Cream City\\\" trên áo, tôn vinh di sản của Milwaukee với những gạch xà phòng trắng đặc trưng.', 52, 1),
(180, 'Áo Icon Houston Rocket 2024', 'HOUI24', 350000, 200, 198, 'HOUI24.png', 'Áo Icon của Houston Rockets năm 2024 là một phần của dòng sản phẩm City Edition năm 2024-2025, được thiết kế để tôn vinh và kết nối với người hâm mộ Rockets. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Các đặc điểm nổi bật của áo Icon 2024 bao gồm:\\n\\nThiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Rockets, bao gồm màu trắng và dòng chữ \\\"H-TOWN\\\" trên áo với màu đỏ và nét đen.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Houston Rockets, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Believe It Again\\\": Áo này có dòng chữ \\\"Believe It Again\\\" trên áo, tôn vinh sức mạnh và tinh thần của đội và thành phố Houston.', 52, 1),
(181, 'Áo Association Houston Rocket 2024', 'HOUA24', 350000, 200, 198, 'HOUA24.jpg', 'Áo Association của Houston Rockets năm 2024 là một phần trong dòng sản phẩm thường niên của NBA, được thiết kế để tôn vinh và kết nối với người hâm mộ Rockets. Đây là một món đồ thể thao chất lượng cao, được làm từ chất liệu Nike Dri-FIT giúp người mặc cảm thấy thoải mái và khô ráo.', 'Thiết kế đơn giản và hiện đại: Áo có thiết kế tinh tế với màu sắc đặc trưng của Rockets, bao gồm màu trắng và màu đỏ.\\n\\nChất liệu chất lượng cao: Sử dụng chất liệu Nike Dri-FIT giúp người mặc luôn cảm thấy thoải mái và khô ráo.\\n\\nLogo và số hiệu: Áo có logo và số hiệu của Houston Rockets, cùng với logo của Nike và Cleveland-Cliffs patch.\\n\\nSlogan \\\"Believe It Again\\\": Áo này có dòng chữ \\\"Believe It Again\\\" trên áo, tôn vinh sức mạnh và tinh thần của đội và thành phố Houston.', 52, 1),
(182, 'Áo Icon Chicago Bulls 2024', 'BULI24', 350000, 200, 198, 'BULI24.jpg', 'Áo Icon năm 2024 của Chicago Bulls mang đến một phong cách cổ điển, mạnh mẽ và sạch sẽ, tương tự như United Center. Thiết kế này không chỉ thể hiện sự kỷ niệm mà còn tôn vinh lịch sử và vẻ đẹp của sân nhà Bulls.', 'Thiết kế đặc biệt: Áo có màu trắng với viền và chữ \\\"Bulls\\\" trên ngực được viết bằng màu xám và viền vàng.\\n\\nHình ảnh biểu tượng: Áo có các ngôi sao đặc trưng của lá cờ Chicago trên hai bên.\\n\\nChi tiết kỷ niệm: Jock tag trên áo tôn vinh bảng viết ngoài sân United Center ghi \\\"Home of the Bulls\\\"', 52, 1),
(183, 'Áo Association Chicago Bulls 2024', 'BULA24', 250000, 300, 298, 'Bula24.jpg', 'Áo Association năm 2024 của Chicago Bulls mang đến một phong cách cổ điển, mạnh mẽ và sạch sẽ, tương tự như United Center. Thiết kế này không chỉ thể hiện sự kỷ niệm mà còn tôn vinh lịch sử và vẻ đẹp của sân nhà Bulls.', 'Thiết kế đặc biệt: Áo có màu trắng với viền và chữ \\\"Bulls\\\" trên ngực được viết bằng màu xám và viền vàng.\\n\\nHình ảnh biểu tượng: Áo có các ngôi sao đặc trưng của lá cờ Chicago trên hai bên.\\n\\nChi tiết kỷ niệm: Jock tag trên áo tôn vinh bảng viết ngoài sân United Center ghi \\\"Home of the Bulls\\\".', 52, 1),
(184, 'Áo Icon Phoenix Suns 2024', 'SUNI24', 350000, 200, 198, 'SUNI24.jpg', 'Áo Icon năm 2024 của Phoenix Suns mang đến một phong cách hiện đại, sáng tạo và truyền thống, kết hợp giữa sự kỷ niệm và phong cách mới của Suns. Thiết kế này không chỉ thể hiện sự kỷ niệm mà còn tôn vinh lịch sử và vẻ đẹp của đội bóng.', 'Thiết kế đặc biệt: Áo có màu tím với viền và chữ \\\"Suns\\\" trên ngực được viết bằng màu vàng và viền đen.\\n\\nHình ảnh biểu tượng: Áo có hình ảnh mặt trời mọc đặc trưng của Suns trên cổ tay trái.\\n\\nChi tiết kỷ niệm: Áo có số hiệu khắc trên áo và chân áo có thiết kế không đối xứng với logo \\\"Phoenix\\\" trên chân áo', 52, 1),
(185, 'Áo Association Phoenix Suns 2024', 'SUNA24', 250000, 150, 150, 'SUNA24.jpg', 'Sản phẩm áo Association của Phoenix Suns 2024 là một phần trong dòng sản phẩm đội ngũ Nike của đội bóng rổ này. Áo này có thiết kế độc đáo với biểu tượng sóng mặt trời và chữ \\\"Suns\\\" được khắc trên áo, cùng với số viền khui. Thiết kế này mang lại sự tương tác tốt với trang phục đội ngũ và mang lại cảm giác hiện đại, năng động.', 'Sản phẩm áo Association của Phoenix Suns 2024 là một phần trong dòng sản phẩm đội ngũ Nike của đội bóng rổ này. Áo này có thiết kế độc đáo với biểu tượng sóng mặt trời và chữ \\\"Suns\\\" được khắc trên áo, cùng với số viền khui. Thiết kế này mang lại sự tương tác tốt với trang phục đội ngũ và mang lại cảm giác hiện đại, năng động.\\n\\nÁo này được làm từ vải polyester tái chế, giúp giữ cho bạn mát mẻ và thoáng mát trên và ngoài sân. Ngoài ra, áo cũng có thiết kế nhẹ, tiện dụng, phù hợp để bạn có thể đeo trong suốt mùa giải.', 52, 1),
(188, 'Áo bóng chuyền nam Pro Player', 'ABC001', 350000, 100, 98, 'bc1.jpg', 'Áo bóng chuyền dành cho vận động viên chuyên nghiệp.', 'Áo bóng chuyền nam Pro Player được thiết kế đặc biệt cho các vận động viên chuyên nghiệp, mang lại hiệu suất tối đa trong mọi trận đấu. Với chất liệu cao cấp, áo đảm bảo khả năng co giãn 4 chiều, thấm hút mồ hôi hiệu quả, giữ cơ thể luôn khô thoáng và thoải mái. Đường may tỉ mỉ, họa tiết hiện đại giúp bạn tự tin cả trong và ngoài sân đấu.', 66, 1),
(189, 'Áo bóng chuyền nam Basic Fit', 'ABC002', 300000, 120, 120, 'bc2.jpg', 'Áo bóng chuyền kiểu dáng đơn giản.', 'Áo bóng chuyền nam Basic Fit là sự lựa chọn hoàn hảo cho các buổi luyện tập và trận đấu phong trào. Chất liệu cotton pha polyester giúp áo vừa mềm mại vừa bền bỉ. Thiết kế đơn giản nhưng tinh tế, dễ dàng phối hợp với các trang phục khác. Đường cắt vừa vặn giúp bạn thoải mái vận động suốt cả ngày.', 66, 1),
(190, 'Áo bóng chuyền nam CoolMax', 'ABC003', 400000, 80, 80, 'bc3.jpg', 'Áo bóng chuyền công nghệ làm mát.', 'Áo bóng chuyền CoolMax là sản phẩm cao cấp với công nghệ làm mát hiện đại. Sợi vải CoolMax giúp tăng cường luồng không khí, giảm nhiệt độ cơ thể trong khi thi đấu. Áo có thiết kế ôm sát cơ thể nhưng không gây bí bách. Đây là lựa chọn lý tưởng cho các trận đấu kéo dài hoặc trong điều kiện thời tiết nóng.', 66, 1),
(191, 'Áo bóng chuyền nam FlexMotion', 'ABC004', 450000, 90, 90, 'bc4.jpg', 'Áo bóng chuyền co giãn tối đa.', 'FlexMotion mang đến sự tự do tối đa trong mọi chuyển động. Sản phẩm sử dụng chất liệu spandex kết hợp polyester, giúp áo luôn đàn hồi mà không mất đi hình dáng ban đầu. Thiết kế năng động, đường viền cổ và tay áo gia cố chắc chắn, phù hợp với những người yêu cầu cao về hiệu suất thi đấu.', 66, 1),
(192, 'Áo bóng chuyền nam Dynamic Play', 'ABC005', 320000, 110, 110, 'bc5.jpg', 'Áo bóng chuyền dành cho mọi lứa tuổi.', 'Dynamic Play là mẫu áo dành cho mọi lứa tuổi, được yêu thích nhờ phong cách trẻ trung và năng động. Với đường may chắc chắn và chất liệu bền bỉ, áo thích hợp cho cả luyện tập và thi đấu. Họa tiết in nổi bật giúp người mặc luôn thu hút ánh nhìn trên sân.', 66, 1),
(193, 'Áo bóng chuyền nam ActiveFit', 'ABC006', 380000, 100, 100, 'bc6.jpg', 'Áo bóng chuyền nam thiết kế ôm gọn.', 'Áo ActiveFit với thiết kế ôm gọn, tôn dáng người mặc, mang lại vẻ ngoài mạnh mẽ và tự tin. Chất liệu tổng hợp cao cấp giúp áo luôn mềm mại, giảm thiểu ma sát trong quá trình vận động. Sản phẩm phù hợp cho các vận động viên yêu thích sự năng động và linh hoạt.', 66, 1),
(194, 'Áo bóng chuyền nam Thunder Strike', 'ABC007', 410000, 90, 90, 'bc7.jpg', 'Áo bóng chuyền họa tiết sấm sét.', 'Họa tiết sấm sét mạnh mẽ là điểm nhấn chính của Thunder Strike. Mẫu áo này được thiết kế cho những ai muốn thể hiện cá tính trên sân bóng. Chất liệu cao cấp giúp áo bền bỉ, không phai màu sau nhiều lần giặt. Đường cắt may khéo léo đảm bảo sự thoải mái tối đa.', 66, 1),
(195, 'Áo bóng chuyền nam EnergyBoost', 'ABC008', 390000, 95, 94, 'bc8.jpg', 'Áo bóng chuyền hỗ trợ hiệu suất tối đa.', 'EnergyBoost là mẫu áo bóng chuyền hỗ trợ tối đa cho các vận động viên muốn tăng cường hiệu suất. Công nghệ dệt vải tiên tiến giúp giảm sức cản gió, tăng độ bền và giảm mệt mỏi. Áo còn được bổ sung khả năng kháng khuẩn, giữ cơ thể luôn tươi mới.', 66, 1),
(196, 'Áo bóng chuyền nam SummerBreeze', 'ABC009', 360000, 80, 79, 'bc9.jpg', 'Áo bóng chuyền thoáng mát mùa hè.', 'Với SummerBreeze, bạn không còn phải lo lắng về cái nóng của mùa hè. Chất liệu vải siêu thoáng, nhẹ như lông vũ giúp bạn dễ dàng di chuyển. Mẫu áo này cũng phù hợp cho các hoạt động thể thao ngoài trời khác, mang lại cảm giác dễ chịu suốt cả ngày.', 66, 1),
(197, 'Áo bóng chuyền nam Storm Defender', 'ABC010', 420000, 70, 69, 'bc10.jpg', 'Áo bóng chuyền chất liệu chống thấm.', 'Storm Defender được thiết kế đặc biệt để bảo vệ cơ thể trong điều kiện ẩm ướt. Chất liệu chống thấm nước kết hợp với khả năng thoát khí tốt giúp áo luôn khô ráo. Sản phẩm phù hợp cho các vận động viên thi đấu ngoài trời.', 66, 1),
(198, 'Áo bóng chuyền nam Victory Line', 'ABC011', 350000, 100, 99, 'bc11.jpg', 'Áo bóng chuyền cho người chiến thắng.', 'Mẫu áo Victory Line được thiết kế dành riêng cho những vận động viên yêu thích sự đột phá và tinh thần chiến thắng. Đường may chắc chắn, phối màu táo bạo giúp áo luôn nổi bật trên sân. Đây là mẫu áo được nhiều đội bóng chuyên nghiệp tin dùng.', 66, 1),
(199, 'Áo bóng chuyền nam SprintFlow', 'ABC012', 340000, 120, 118, 'bc12.jpg', 'Áo bóng chuyền dành cho người yêu tốc độ.', 'SprintFlow mang đến cảm giác nhẹ nhàng và thoải mái cho các vận động viên. Công nghệ vải Aeroflow giúp tăng tốc độ di chuyển và giảm nhiệt độ cơ thể. Mẫu áo phù hợp cho các trận đấu căng thẳng yêu cầu hiệu suất cao.', 66, 1),
(200, 'Áo bóng chuyền nam Diamond Edge', 'ABC013', 450000, 75, 75, 'bc13.jpg', 'Áo bóng chuyền cao cấp với đường viền sắc nét.', 'Diamond Edge được thiết kế để tôn lên vẻ ngoài sang trọng và mạnh mẽ. Chất liệu cao cấp kết hợp với đường viền sắc nét tạo nên sự khác biệt. Áo cũng được trang bị khả năng chống mài mòn, đảm bảo độ bền lâu dài.', 66, 1),
(201, 'Áo bóng chuyền nam SwiftAir', 'ABC014', 370000, 85, 84, 'bc14.jpg', 'Áo bóng chuyền nhẹ nhàng và thoải mái.', 'SwiftAir là sự lựa chọn hoàn hảo cho những ai yêu thích sự đơn giản và thoải mái. Sản phẩm sử dụng công nghệ giảm áp lực lên cơ thể, mang lại trải nghiệm vận động nhẹ nhàng. Áo có thiết kế tối giản nhưng không kém phần hiện đại.', 66, 1),
(202, 'Áo bóng chuyền nam Limitless Motion', 'ABC015', 480000, 65, 64, 'bc15.jpg', 'Áo bóng chuyền mang lại sự tự do vận động.', 'Limitless Motion được tạo ra để mang lại sự tự do tuyệt đối trong từng chuyển động. Chất liệu cao cấp, co giãn tối đa kết hợp với thiết kế ôm sát cơ thể giúp bạn luôn đạt phong độ tốt nhất trong các trận đấu đỉnh cao.', 66, 1),
(203, 'Áo cầu lông nam Pro Smash', 'ACL001', 350000, 100, 99, 'cl1.jpg', 'Áo cầu lông dành cho vận động viên chuyên nghiệp.', 'Áo cầu lông Pro Smash được thiết kế tối ưu cho các vận động viên chuyên nghiệp. Chất liệu cao cấp giúp thấm hút mồ hôi nhanh chóng, giữ cơ thể luôn khô thoáng trong các trận đấu căng thẳng. Đường cắt may tỉ mỉ, họa tiết năng động giúp bạn luôn nổi bật trên sân.', 67, 1),
(204, 'Áo cầu lông nam FeatherLight', 'ACL002', 320000, 110, 110, 'cl2.jpg', 'Áo cầu lông siêu nhẹ, dễ vận động.', 'FeatherLight là mẫu áo cầu lông nổi bật với thiết kế siêu nhẹ, mang lại cảm giác thoải mái và linh hoạt tối đa. Chất liệu vải thoáng khí giúp giảm nhiệt độ cơ thể, giữ cho vận động viên luôn tươi mới. Thiết kế tối giản, trẻ trung, phù hợp với mọi đối tượng.', 67, 1),
(205, 'Áo cầu lông nam PowerStroke', 'ACL003', 400000, 90, 90, 'cl3.jpg', 'Áo cầu lông nam hỗ trợ sức mạnh.', 'PowerStroke mang đến sự hỗ trợ tối đa cho các vận động viên yêu thích sự mạnh mẽ. Công nghệ vải nén giúp tăng cường sức mạnh tay và giảm mệt mỏi. Mẫu áo này còn được tích hợp khả năng chống tia UV, bảo vệ da khi chơi ngoài trời.', 67, 1),
(206, 'Áo cầu lông nam AeroFlow', 'ACL004', 450000, 85, 85, 'cl4.jpg', 'Áo cầu lông nam với khả năng lưu thông khí vượt trội.', 'AeroFlow là sản phẩm được thiết kế đặc biệt để tối ưu hóa khả năng lưu thông khí. Chất liệu vải tiên tiến, nhẹ nhàng, thoáng mát giúp vận động viên tự tin trong mọi pha cầu. Đường may chắc chắn, độ bền cao là điểm cộng lớn của mẫu áo này.', 67, 1),
(207, 'Áo cầu lông nam FlexSpeed', 'ACL005', 380000, 95, 95, 'cl5.jpg', 'Áo cầu lông linh hoạt, tốc độ.', 'FlexSpeed giúp tăng tốc độ di chuyển nhờ chất liệu vải co giãn đa chiều. Thiết kế vừa vặn với đường may chắc chắn mang lại sự linh hoạt tối đa trong mọi pha cầu. Mẫu áo này thích hợp cho cả người chơi phong trào và chuyên nghiệp.', 67, 1),
(208, 'Áo cầu lông nam Victory Smash', 'ACL006', 410000, 90, 90, 'cl6.jpg', 'Áo cầu lông cho người chiến thắng.', 'Victory Smash là mẫu áo được tạo ra dành riêng cho những người yêu thích sự nổi bật. Với họa tiết táo bạo và đường may tỉ mỉ, sản phẩm giúp bạn luôn tự tin trong mọi trận đấu. Chất liệu cao cấp đảm bảo áo bền đẹp sau nhiều lần giặt.', 67, 1),
(209, 'Áo cầu lông nam SpeedMaster', 'ACL007', 340000, 100, 100, 'cl7.jpg', 'Áo cầu lông tối ưu hiệu suất.', 'SpeedMaster mang lại hiệu suất tối ưu nhờ thiết kế tinh tế và chất liệu nhẹ nhàng. Công nghệ chống bám bụi giúp áo luôn sạch sẽ sau mỗi trận đấu. Đây là lựa chọn hoàn hảo cho các vận động viên yêu thích tốc độ.', 67, 1),
(210, 'Áo cầu lông nam Lightning Strike', 'ACL008', 390000, 80, 77, 'cl8.jpg', 'Áo cầu lông họa tiết tia chớp.', 'Lightning Strike với họa tiết tia chớp là biểu tượng của sự mạnh mẽ và tốc độ. Chất liệu vải bền bỉ, thoáng khí giúp bạn luôn tự tin trên sân. Mẫu áo này thích hợp cho các trận đấu đỉnh cao.', 67, 1);
INSERT INTO `tbl_sanpham` (`id_sp`, `ten_sp`, `ma_sp`, `gia_sp`, `so_luong`, `so_luong_con_lai`, `hinh_anh`, `tom_tat`, `noi_dung`, `id_dm`, `tinh_trang`) VALUES
(211, 'Áo cầu lông nam CoolBreeze', 'ACL009', 360000, 120, 120, 'cl9.jpg', 'Áo cầu lông thoáng mát.', 'Mẫu áo CoolBreeze mang lại cảm giác thoải mái tối đa nhờ chất liệu vải thoáng khí. Đây là sản phẩm lý tưởng cho những ai thường xuyên thi đấu trong điều kiện thời tiết nóng bức. Áo còn có khả năng thấm hút mồ hôi hiệu quả, giữ cơ thể luôn khô ráo.', 67, 1),
(212, 'Áo cầu lông nam StrikeForce', 'ACL010', 420000, 75, 75, 'cl10.jpg', 'Áo cầu lông hỗ trợ động lực mạnh mẽ.', 'StrikeForce được thiết kế với đường nét mạnh mẽ, tôn lên sự năng động và cá tính của người mặc. Chất liệu chống mài mòn giúp áo bền bỉ, đồng hành cùng bạn qua mọi trận đấu khốc liệt.', 67, 1),
(213, 'Áo cầu lông nam SwiftMotion', 'ACL011', 350000, 90, 89, 'cl11.jpg', 'Áo cầu lông giúp tăng tốc độ.', 'SwiftMotion giúp bạn đạt tốc độ tối đa nhờ thiết kế ôm sát cơ thể và chất liệu vải nhẹ nhàng. Mẫu áo này mang lại cảm giác thoải mái và tự tin trong mọi pha cầu. Sản phẩm thích hợp cho các vận động viên chuyên nghiệp.', 67, 1),
(214, 'Áo cầu lông nam WindCutter', 'ACL012', 370000, 85, 85, 'cl12.jpg', 'Áo cầu lông giảm sức cản gió.', 'WindCutter được thiết kế đặc biệt để giảm sức cản gió, mang lại sự thoải mái tối đa. Với chất liệu cao cấp, mẫu áo này phù hợp với cả thi đấu và luyện tập. Thiết kế hiện đại, phối màu trẻ trung tạo nên phong cách riêng biệt.', 67, 1),
(215, 'Áo cầu lông nam BladeRunner', 'ACL013', 390000, 100, 96, 'cl13.jpg', 'Áo cầu lông bền bỉ và sắc sảo.', 'BladeRunner là mẫu áo được thiết kế cho những người yêu thích sự mạnh mẽ. Chất liệu vải bền bỉ, đường may chắc chắn giúp áo giữ nguyên dáng sau nhiều lần giặt. Mẫu áo này mang lại sự thoải mái và tự tin trong suốt trận đấu.', 67, 1),
(216, 'Áo cầu lông nam AeroStrike', 'ACL014', 410000, 110, 110, 'cl14.jpg', 'Áo cầu lông với khả năng làm mát tuyệt vời.', 'AeroStrike sử dụng công nghệ làm mát tiên tiến, mang lại sự thoải mái và nhẹ nhàng trong từng chuyển động. Sản phẩm còn được tích hợp khả năng chống mùi, giúp bạn tự tin thi đấu cả ngày.', 67, 1),
(217, 'Áo cầu lông nam Supreme Control', 'ACL015', 450000, 70, 70, 'cl15.jpg', 'Áo cầu lông kiểm soát tối ưu.', 'Supreme Control mang lại khả năng kiểm soát tối ưu trong mọi pha cầu. Với chất liệu co giãn 4 chiều, áo giúp vận động viên dễ dàng thực hiện các động tác kỹ thuật khó. Đây là lựa chọn hoàn hảo cho những ai yêu thích sự chính xác và hiệu suất.', 67, 1),
(218, 'Áo cầu lông nam SpeedFlex', 'ACL016', 360000, 100, 93, 'cl16.jpg', 'Áo cầu lông nhanh chóng, linh hoạt.', 'SpeedFlex được thiết kế cho những ai yêu thích sự linh hoạt và tốc độ. Với chất liệu nhẹ và co giãn, áo giúp bạn di chuyển dễ dàng trong mọi trận đấu. Thiết kế thể thao, trẻ trung phù hợp với nhiều đối tượng vận động viên.', 67, 1),
(219, 'Áo cầu lông nam TurboSpeed', 'ACL017', 380000, 95, 92, 'cl17.jpg', 'Áo cầu lông sở hữu siêu tốc độ.', 'TurboSpeed mang đến cảm giác tốc độ tuyệt vời nhờ thiết kế ôm sát và chất liệu vải siêu nhẹ. Áo giúp bạn đạt được tốc độ tối đa trong mọi chuyển động. Dễ dàng giặt sạch và giữ màu sắc lâu dài.', 67, 1),
(220, 'Áo cầu lông nam UltraStrike', 'ACL018', 420000, 85, 75, 'cl18.jpg', 'Áo cầu lông cho chiến thuật tấn công.', 'UltraStrike là sự lựa chọn tuyệt vời cho những vận động viên yêu thích lối chơi tấn công. Chất liệu vải giúp thấm hút mồ hôi hiệu quả, giữ cơ thể khô ráo và thoải mái suốt trận đấu. Họa tiết mạnh mẽ, phù hợp với những pha tấn công quyết đoán.', 67, 1),
(221, 'Áo cầu lông nam PowerFlex', 'ACL019', 400000, 90, 40, 'cl19.jpg', 'Áo cầu lông với sự kết hợp giữa sức mạnh và linh hoạt.', 'PowerFlex được thiết kế đặc biệt với chất liệu co giãn giúp bạn dễ dàng thực hiện mọi động tác mà không lo hạn chế. Đường may chắc chắn, đồng thời hỗ trợ tối đa các vận động viên trong những pha cầu mạnh mẽ.', 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanpham_sizes`
--

CREATE TABLE `tbl_sanpham_sizes` (
  `id` int(11) NOT NULL,
  `id_sp` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `so_luong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sanpham_sizes`
--

INSERT INTO `tbl_sanpham_sizes` (`id`, `id_sp`, `size`, `so_luong`) VALUES
(1, 140, 'S', 20),
(2, 140, 'M', 20),
(3, 140, 'L', 20),
(4, 140, 'XL', 20),
(5, 140, 'XXL', 20),
(6, 141, 'S', 20),
(7, 141, 'M', 20),
(8, 141, 'L', 20),
(9, 141, 'XL', 20),
(10, 141, 'XXL', 20),
(11, 142, 'S', 19),
(12, 142, 'M', 20),
(13, 142, 'L', 20),
(14, 142, 'XL', 20),
(15, 142, 'XXL', 20),
(16, 143, 'S', 20),
(17, 143, 'M', 20),
(18, 143, 'L', 20),
(19, 143, 'XL', 20),
(20, 143, 'XXL', 20),
(21, 144, 'S', 20),
(22, 144, 'M', 20),
(23, 144, 'L', 20),
(24, 144, 'XL', 20),
(25, 144, 'XXL', 20),
(26, 150, 'S', 39),
(27, 150, 'M', 40),
(28, 150, 'L', 40),
(29, 150, 'XL', 40),
(30, 150, 'XXL', 40),
(31, 151, 'S', 29),
(32, 151, 'M', 30),
(33, 151, 'L', 30),
(34, 151, 'XL', 30),
(35, 151, 'XXL', 30),
(36, 152, 'S', 30),
(37, 152, 'M', 30),
(38, 152, 'L', 30),
(39, 152, 'XL', 30),
(40, 152, 'XXL', 30),
(41, 153, 'S', 34),
(42, 153, 'M', 35),
(43, 153, 'L', 35),
(44, 153, 'XL', 35),
(45, 153, 'XXL', 35),
(46, 154, 'S', 24),
(47, 154, 'M', 24),
(48, 154, 'L', 24),
(49, 154, 'XL', 24),
(50, 154, 'XXL', 24),
(51, 155, 'S', 20),
(52, 155, 'M', 20),
(53, 155, 'L', 20),
(54, 155, 'XL', 20),
(55, 155, 'XXL', 20),
(56, 156, 'S', 20),
(57, 156, 'M', 20),
(58, 156, 'L', 20),
(59, 156, 'XL', 20),
(60, 156, 'XXL', 20),
(61, 157, 'S', 37),
(62, 157, 'M', 38),
(63, 157, 'L', 38),
(64, 157, 'XL', 38),
(65, 157, 'XXL', 38),
(66, 158, 'S', 36),
(67, 158, 'M', 36),
(68, 158, 'L', 36),
(69, 158, 'XL', 36),
(70, 158, 'XXL', 36),
(71, 159, 'S', 20),
(72, 159, 'M', 20),
(73, 159, 'L', 20),
(74, 159, 'XL', 20),
(75, 159, 'XXL', 20),
(76, 160, 'S', 19),
(77, 160, 'M', 20),
(78, 160, 'L', 20),
(79, 160, 'XL', 20),
(80, 160, 'XXL', 20),
(81, 161, 'S', 36),
(82, 161, 'M', 36),
(83, 161, 'L', 36),
(84, 161, 'XL', 36),
(85, 161, 'XXL', 36),
(86, 162, 'S', 49),
(87, 162, 'M', 50),
(88, 162, 'L', 50),
(89, 162, 'XL', 50),
(90, 162, 'XXL', 50),
(91, 163, 'S', 39),
(92, 163, 'M', 40),
(93, 163, 'L', 40),
(94, 163, 'XL', 40),
(95, 163, 'XXL', 40),
(96, 164, 'S', 29),
(97, 164, 'M', 30),
(98, 164, 'L', 30),
(99, 164, 'XL', 30),
(100, 164, 'XXL', 29),
(101, 165, 'S', 20),
(102, 165, 'M', 20),
(103, 165, 'L', 20),
(104, 165, 'XL', 20),
(105, 165, 'XXL', 20),
(106, 166, 'S', 20),
(107, 166, 'M', 20),
(108, 166, 'L', 20),
(109, 166, 'XL', 20),
(110, 166, 'XXL', 20),
(111, 167, 'S', 40),
(112, 167, 'M', 40),
(113, 167, 'L', 40),
(114, 167, 'XL', 40),
(115, 167, 'XXL', 40),
(116, 168, 'S', 60),
(117, 168, 'M', 60),
(118, 168, 'L', 60),
(119, 168, 'XL', 60),
(120, 168, 'XXL', 60),
(121, 169, 'S', 20),
(122, 169, 'M', 20),
(123, 169, 'L', 20),
(124, 169, 'XL', 20),
(125, 169, 'XXL', 20),
(126, 170, 'S', 39),
(127, 170, 'M', 40),
(128, 170, 'L', 40),
(129, 170, 'XL', 40),
(130, 170, 'XXL', 40),
(131, 172, 'S', 39),
(132, 172, 'M', 40),
(133, 172, 'L', 40),
(134, 172, 'XL', 40),
(135, 172, 'XXL', 40),
(136, 173, 'S', 40),
(137, 173, 'M', 40),
(138, 173, 'L', 40),
(139, 173, 'XL', 40),
(140, 173, 'XXL', 40),
(141, 174, 'S', 40),
(142, 174, 'M', 40),
(143, 174, 'L', 40),
(144, 174, 'XL', 40),
(145, 174, 'XXL', 40),
(146, 175, 'S', 60),
(147, 175, 'M', 60),
(148, 175, 'L', 60),
(149, 175, 'XL', 60),
(150, 175, 'XXL', 60),
(151, 176, 'S', 40),
(152, 176, 'M', 40),
(153, 176, 'L', 40),
(154, 176, 'XL', 40),
(155, 176, 'XXL', 40),
(156, 177, 'S', 40),
(157, 177, 'M', 40),
(158, 177, 'L', 40),
(159, 177, 'XL', 40),
(160, 177, 'XXL', 40),
(161, 178, 'S', 40),
(162, 178, 'M', 40),
(163, 178, 'L', 40),
(164, 178, 'XL', 40),
(165, 178, 'XXL', 40),
(166, 179, 'S', 40),
(167, 179, 'M', 40),
(168, 179, 'L', 40),
(169, 179, 'XL', 40),
(170, 179, 'XXL', 40),
(171, 180, 'S', 39),
(172, 180, 'M', 40),
(173, 180, 'L', 40),
(174, 180, 'XL', 40),
(175, 180, 'XXL', 39),
(176, 181, 'S', 39),
(177, 181, 'M', 40),
(178, 181, 'L', 40),
(179, 181, 'XL', 40),
(180, 181, 'XXL', 39),
(181, 182, 'S', 39),
(182, 182, 'M', 40),
(183, 182, 'L', 40),
(184, 182, 'XL', 40),
(185, 182, 'XXL', 39),
(186, 183, 'S', 59),
(187, 183, 'M', 60),
(188, 183, 'L', 60),
(189, 183, 'XL', 60),
(190, 183, 'XXL', 59),
(191, 184, 'S', 39),
(192, 184, 'M', 40),
(193, 184, 'L', 40),
(194, 184, 'XL', 40),
(195, 184, 'XXL', 39),
(196, 185, 'S', 30),
(197, 185, 'M', 30),
(198, 185, 'L', 30),
(199, 185, 'XL', 30),
(200, 185, 'XXL', 30),
(201, 188, 'S', 19),
(202, 188, 'M', 20),
(203, 188, 'L', 20),
(204, 188, 'XL', 20),
(205, 188, 'XXL', 19),
(206, 189, 'S', 24),
(207, 189, 'M', 24),
(208, 189, 'L', 24),
(209, 189, 'XL', 24),
(210, 189, 'XXL', 24),
(211, 190, 'S', 16),
(212, 190, 'M', 16),
(213, 190, 'L', 16),
(214, 190, 'XL', 16),
(215, 190, 'XXL', 16),
(216, 191, 'S', 18),
(217, 191, 'M', 18),
(218, 191, 'L', 18),
(219, 191, 'XL', 18),
(220, 191, 'XXL', 18),
(221, 192, 'S', 22),
(222, 192, 'M', 22),
(223, 192, 'L', 22),
(224, 192, 'XL', 22),
(225, 192, 'XXL', 22),
(226, 193, 'S', 20),
(227, 193, 'M', 20),
(228, 193, 'L', 20),
(229, 193, 'XL', 20),
(230, 193, 'XXL', 20),
(231, 194, 'S', 18),
(232, 194, 'M', 18),
(233, 194, 'L', 18),
(234, 194, 'XL', 18),
(235, 194, 'XXL', 18),
(236, 195, 'S', 18),
(237, 195, 'M', 19),
(238, 195, 'L', 19),
(239, 195, 'XL', 19),
(240, 195, 'XXL', 19),
(241, 196, 'S', 15),
(242, 196, 'M', 16),
(243, 196, 'L', 16),
(244, 196, 'XL', 16),
(245, 196, 'XXL', 16),
(246, 197, 'S', 13),
(247, 197, 'M', 14),
(248, 197, 'L', 14),
(249, 197, 'XL', 14),
(250, 197, 'XXL', 14),
(251, 198, 'S', 19),
(252, 198, 'M', 20),
(253, 198, 'L', 20),
(254, 198, 'XL', 20),
(255, 198, 'XXL', 20),
(256, 199, 'S', 23),
(257, 199, 'M', 24),
(258, 199, 'L', 24),
(259, 199, 'XL', 24),
(260, 199, 'XXL', 23),
(261, 200, 'S', 15),
(262, 200, 'M', 15),
(263, 200, 'L', 15),
(264, 200, 'XL', 15),
(265, 200, 'XXL', 15),
(266, 201, 'S', 16),
(267, 201, 'M', 17),
(268, 201, 'L', 17),
(269, 201, 'XL', 17),
(270, 201, 'XXL', 17),
(271, 202, 'S', 12),
(272, 202, 'M', 13),
(273, 202, 'L', 13),
(274, 202, 'XL', 13),
(275, 202, 'XXL', 13),
(276, 203, 'S', 19),
(277, 203, 'M', 20),
(278, 203, 'L', 20),
(279, 203, 'XL', 20),
(280, 203, 'XXL', 20),
(281, 204, 'S', 22),
(282, 204, 'M', 22),
(283, 204, 'L', 22),
(284, 204, 'XL', 22),
(285, 204, 'XXL', 22),
(286, 205, 'S', 18),
(287, 205, 'M', 18),
(288, 205, 'L', 18),
(289, 205, 'XL', 18),
(290, 205, 'XXL', 18),
(291, 206, 'S', 17),
(292, 206, 'M', 17),
(293, 206, 'L', 17),
(294, 206, 'XL', 17),
(295, 206, 'XXL', 17),
(296, 207, 'S', 19),
(297, 207, 'M', 19),
(298, 207, 'L', 19),
(299, 207, 'XL', 19),
(300, 207, 'XXL', 19),
(301, 208, 'S', 18),
(302, 208, 'M', 18),
(303, 208, 'L', 18),
(304, 208, 'XL', 18),
(305, 208, 'XXL', 18),
(306, 209, 'S', 20),
(307, 209, 'M', 20),
(308, 209, 'L', 20),
(309, 209, 'XL', 20),
(310, 209, 'XXL', 20),
(311, 210, 'S', 15),
(312, 210, 'M', 16),
(313, 210, 'L', 16),
(314, 210, 'XL', 15),
(315, 210, 'XXL', 15),
(316, 211, 'S', 24),
(317, 211, 'M', 24),
(318, 211, 'L', 24),
(319, 211, 'XL', 24),
(320, 211, 'XXL', 24),
(321, 212, 'S', 15),
(322, 212, 'M', 15),
(323, 212, 'L', 15),
(324, 212, 'XL', 15),
(325, 212, 'XXL', 15),
(326, 213, 'S', 17),
(327, 213, 'M', 18),
(328, 213, 'L', 18),
(329, 213, 'XL', 18),
(330, 213, 'XXL', 18),
(331, 214, 'S', 17),
(332, 214, 'M', 17),
(333, 214, 'L', 17),
(334, 214, 'XL', 17),
(335, 214, 'XXL', 17),
(336, 215, 'S', 19),
(337, 215, 'M', 20),
(338, 215, 'L', 19),
(339, 215, 'XL', 19),
(340, 215, 'XXL', 19),
(341, 216, 'S', 22),
(342, 216, 'M', 22),
(343, 216, 'L', 22),
(344, 216, 'XL', 22),
(345, 216, 'XXL', 22),
(346, 217, 'S', 14),
(347, 217, 'M', 14),
(348, 217, 'L', 14),
(349, 217, 'XL', 14),
(350, 217, 'XXL', 14),
(351, 218, 'S', 18),
(352, 218, 'M', 19),
(353, 218, 'L', 19),
(354, 218, 'XL', 19),
(355, 218, 'XXL', 18),
(356, 219, 'S', 18),
(357, 219, 'M', 19),
(358, 219, 'L', 19),
(359, 219, 'XL', 18),
(360, 219, 'XXL', 18),
(361, 220, 'S', 15),
(362, 220, 'M', 15),
(363, 220, 'L', 15),
(364, 220, 'XL', 15),
(365, 220, 'XXL', 15),
(366, 221, 'S', 9),
(367, 221, 'M', 11),
(368, 221, 'L', 10),
(369, 221, 'XL', 0),
(370, 221, 'XXL', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thongke`
--

CREATE TABLE `tbl_thongke` (
  `id` int(11) NOT NULL,
  `ngaydat` varchar(20) NOT NULL,
  `donhang` int(11) NOT NULL,
  `doanhthu` varchar(100) NOT NULL,
  `soluongdaban` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_thongke`
--

INSERT INTO `tbl_thongke` (`id`, `ngaydat`, `donhang`, `doanhthu`, `soluongdaban`) VALUES
(2, '2024-05-01', 1, '100000', 4),
(10, '2024-05-03', 2, '1000000', 10),
(11, '2024-05-04', 4, '1000000', 10),
(12, '2024-05-07', 8, '2000000', 20),
(13, '2024-05-10', 3, '300000', 7),
(14, '2024-05-14', 30, '4000000', 40),
(15, '2024-06-10', 20, '5000000', 40),
(16, '2024-06-20', 8, '10000000', 40),
(17, '2024-06-25', 2, '1000000', 4),
(18, '2024-07-15', 2, '1000000', 4),
(19, '2024-07-30', 5, '1500000', 7),
(20, '2024-08-3', 1, '500000', 2),
(21, '2024-08-23', 3, '1500000', 4),
(22, '2024-09-2', 4, '1800000', 6),
(23, '2024-09-28', 2, '7000000', 30),
(24, '2024-10-8', 5, '3000000', 10),
(25, '2024-11-28', 10, '5000000', 20),
(26, '2024-11-30', 1, '1000000', 5),
(27, '2024-11-11', 5, '3000000', 10),
(28, '2024-11-19', 2, '2000000', 8),
(29, '2024-12-01', 22, '10270000', 27),
(30, '2025-09-10', 1, '1200000', 3),
(31, '2025-09-11', 3, '1220000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vnpay`
--

CREATE TABLE `tbl_vnpay` (
  `id_vnpay` int(11) NOT NULL,
  `vnp_amount` varchar(50) NOT NULL,
  `vnp_bankcode` varchar(50) NOT NULL,
  `vnp_banktranno` varchar(50) NOT NULL,
  `vnp_cardtype` varchar(50) NOT NULL,
  `vnp_orderinfo` varchar(100) NOT NULL,
  `vnp_paydate` varchar(50) NOT NULL,
  `vnp_tmncode` varchar(50) NOT NULL,
  `vnp_transactionno` varchar(50) NOT NULL,
  `code_cart` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vnpay`
--

INSERT INTO `tbl_vnpay` (`id_vnpay`, `vnp_amount`, `vnp_bankcode`, `vnp_banktranno`, `vnp_cardtype`, `vnp_orderinfo`, `vnp_paydate`, `vnp_tmncode`, `vnp_transactionno`, `code_cart`) VALUES
(18, '35000000', 'NCB', 'VNP14710892', 'ATM', 'Thanh toán đơn hàng', '20241201115747', 'IZK6416P', '14710892', '674becbcc5eac'),
(19, '35000000', 'NCB', 'VNP14710908', 'ATM', 'Thanh toán đơn hàng', '20241201121603', 'IZK6416P', '14710908', '674bf10c8d99b'),
(20, '35000000', 'NCB', 'VNP14710933', 'ATM', 'Thanh toán đơn hàng', '20241201123053', 'IZK6416P', '14710933', '674bf480116c4'),
(21, '42000000', 'NCB', 'VNP14710970', 'ATM', 'Thanh toán đơn hàng', '20241201131152', 'IZK6416P', '14710970', '674bfe06c43c8'),
(22, '45000000', 'NCB', 'VNP14710976', 'ATM', 'Thanh toán đơn hàng', '20241201131510', 'IZK6416P', '14710976', ''),
(23, '35000000', 'NCB', 'VNP14711400', 'ATM', 'Thanh toán đơn hàng', '20241201172818', 'IZK6416P', '14711400', '674c3a347a351'),
(24, '38000000', 'NCB', 'VNP14711604', 'ATM', 'Thanh toán đơn hàng', '20241201194249', 'IZK6416P', '14711604', '674c59a9a00c0'),
(25, '77000000', 'NCB', 'VNP14711608', 'ATM', 'Thanh toán đơn hàng', '20241201194405', 'IZK6416P', '14711608', '674c5a021c8cf'),
(26, '48000000', 'NCB', 'VNP14711610', 'ATM', 'Thanh toán đơn hàng', '20241201194513', 'IZK6416P', '14711610', '674c5a4e2788a'),
(27, '35000000', 'NCB', 'VNP14711613', 'ATM', 'Thanh toán đơn hàng', '20241201194601', 'IZK6416P', '14711613', '674c5a8371f4d'),
(28, '36000000', 'NCB', 'VNP14711617', 'ATM', 'Thanh toán đơn hàng', '20241201194705', 'IZK6416P', '14711617', '674c5ac428daa'),
(29, '30000000', 'NCB', 'VNP14711620', 'ATM', 'Thanh toán đơn hàng', '20241201194748', 'IZK6416P', '14711620', '674c5ae8a41f0'),
(30, '34900000', 'NCB', 'VNP14711622', 'ATM', 'Thanh toán đơn hàng', '20241201194849', 'IZK6416P', '14711622', '674c5b248a5ff'),
(31, '34000000', 'NCB', 'VNP14711623', 'ATM', 'Thanh toán đơn hàng', '20241201194924', 'IZK6416P', '14711623', '674c5b4f8826c'),
(32, '60000000', 'NCB', 'VNP14711624', 'ATM', 'Thanh toán đơn hàng', '20241201195039', 'IZK6416P', '14711624', '674c5b99eaa2c'),
(33, '70000000', 'NCB', 'VNP14711626', 'ATM', 'Thanh toán đơn hàng', '20241201195135', 'IZK6416P', '14711626', '674c5bd58fc2d'),
(34, '35000000', 'NCB', 'VNP14711627', 'ATM', 'Thanh toán đơn hàng', '20241201195253', 'IZK6416P', '14711627', '674c5c2083122'),
(35, '29900000', 'NCB', 'VNP14711629', 'ATM', 'Thanh toán đơn hàng', '20241201195328', 'IZK6416P', '14711629', '674c5c49bb54a'),
(36, '35000000', 'NCB', 'VNP14711632', 'ATM', 'Thanh toán đơn hàng', '20241201195422', 'IZK6416P', '14711632', '674c5c80cbd10'),
(37, '35000000', 'NCB', 'VNP14711633', 'ATM', 'Thanh toán đơn hàng', '20241201195504', 'IZK6416P', '14711633', '674c5caa9f1a1'),
(38, '35000000', 'NCB', 'VNP14711638', 'ATM', 'Thanh toán đơn hàng', '20241201195553', 'IZK6416P', '14711638', '674c5cdbb8eb6'),
(39, '40000000', 'NCB', 'VNP15163789', 'ATM', 'Thanh toán đơn hàng', '20250910131348', 'IZK6416P', '15163789', '68c116b16a364'),
(40, '42000000', 'NCB', 'VNP15163790', 'ATM', 'Thanh toán đơn hàng', '20250910131433', 'IZK6416P', '15163790', '68c116e973eea'),
(41, '42000000', 'NCB', 'VNP15163793', 'ATM', 'Thanh toán đơn hàng', '20250910131615', 'IZK6416P', '15163793', '68c11748a7ee9');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_xacnhanemail`
--

CREATE TABLE `tbl_xacnhanemail` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0 COMMENT 'Trạng thái xác nhận email (0: chưa xác nhận, 1: đã xác nhận)',
  `verified_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian xác nhận email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_xacnhanemail`
--

INSERT INTO `tbl_xacnhanemail` (`id`, `email`, `token`, `created_at`, `verified`, `verified_at`) VALUES
(22, 'zaikaman123@gmail.com', 'ef88dfbaa4a7221fc47bc3cfbe767790', '2025-09-09 05:16:51', 1, '2025-09-09 05:17:16'),
(28, 'subthinh18@gmail.com', 'c5e2f55a24f783f4672befe4e0cae55f', '2025-09-12 16:58:37', 1, '2025-09-12 16:58:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_ad`);

--
-- Indexes for table `tbl_baiviet`
--
ALTER TABLE `tbl_baiviet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_danhmuc` (`id_danhmuc`);

--
-- Indexes for table `tbl_chat_history`
--
ALTER TABLE `tbl_chat_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `idx_email_session` (`email`,`session_id`);

--
-- Indexes for table `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  ADD PRIMARY KEY (`id_dangky`);

--
-- Indexes for table `tbl_dangky_temp`
--
ALTER TABLE `tbl_dangky_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD UNIQUE KEY `token_unique` (`token`);

--
-- Indexes for table `tbl_danhmucqa`
--
ALTER TABLE `tbl_danhmucqa`
  ADD PRIMARY KEY (`id_dm`);

--
-- Indexes for table `tbl_danhmuc_baiviet`
--
ALTER TABLE `tbl_danhmuc_baiviet`
  ADD PRIMARY KEY (`id_baiviet`);

--
-- Indexes for table `tbl_giaohang`
--
ALTER TABLE `tbl_giaohang`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Indexes for table `tbl_giohangtam`
--
ALTER TABLE `tbl_giohangtam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  ADD PRIMARY KEY (`id_gh`);

--
-- Indexes for table `tbl_lienhe`
--
ALTER TABLE `tbl_lienhe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_momo`
--
ALTER TABLE `tbl_momo`
  ADD PRIMARY KEY (`id_momo`);

--
-- Indexes for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indexes for table `tbl_sanpham_sizes`
--
ALTER TABLE `tbl_sanpham_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Indexes for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  ADD PRIMARY KEY (`id_vnpay`);

--
-- Indexes for table `tbl_xacnhanemail`
--
ALTER TABLE `tbl_xacnhanemail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_verified` (`verified`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_ad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_baiviet`
--
ALTER TABLE `tbl_baiviet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_chat_history`
--
ALTER TABLE `tbl_chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  MODIFY `id_dangky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_dangky_temp`
--
ALTER TABLE `tbl_dangky_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_danhmucqa`
--
ALTER TABLE `tbl_danhmucqa`
  MODIFY `id_dm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_danhmuc_baiviet`
--
ALTER TABLE `tbl_danhmuc_baiviet`
  MODIFY `id_baiviet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_giaohang`
--
ALTER TABLE `tbl_giaohang`
  MODIFY `id_shipping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_giohangtam`
--
ALTER TABLE `tbl_giohangtam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  MODIFY `id_gh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `tbl_lienhe`
--
ALTER TABLE `tbl_lienhe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_momo`
--
ALTER TABLE `tbl_momo`
  MODIFY `id_momo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `tbl_sanpham_sizes`
--
ALTER TABLE `tbl_sanpham_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- AUTO_INCREMENT for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  MODIFY `id_vnpay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_xacnhanemail`
--
ALTER TABLE `tbl_xacnhanemail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_sanpham_sizes`
--
ALTER TABLE `tbl_sanpham_sizes`
  ADD CONSTRAINT `tbl_sanpham_sizes_ibfk_1` FOREIGN KEY (`id_sp`) REFERENCES `tbl_sanpham` (`id_sp`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
