/**
 * Dữ liệu Tỉnh/Thành phố và Quận/Huyện Việt Nam
 * Cập nhật: 11/2024 - Theo Nghị quyết mới nhất
 */

const vietnamAddressData = {
    // Danh sách 63 tỉnh thành phố
    provinces: [
        { id: '01', name: 'Hà Nội', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '79', name: 'Thành phố Hồ Chí Minh', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '31', name: 'Hải Phòng', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '48', name: 'Đà Nẵng', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '92', name: 'Cần Thơ', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '46', name: 'Huế', type: 'Thành phố Trực thuộc Trung ương' },
        { id: '26', name: 'Vĩnh Phúc', type: 'Tỉnh' },
        { id: '27', name: 'Bắc Ninh', type: 'Tỉnh' },
        { id: '22', name: 'Quảng Ninh', type: 'Tỉnh' },
        { id: '30', name: 'Hải Dương', type: 'Tỉnh' },
        { id: '33', name: 'Hưng Yên', type: 'Tỉnh' },
        { id: '34', name: 'Thái Bình', type: 'Tỉnh' },
        { id: '35', name: 'Hà Nam', type: 'Tỉnh' },
        { id: '36', name: 'Nam Định', type: 'Tỉnh' },
        { id: '37', name: 'Ninh Bình', type: 'Tỉnh' },
        { id: '02', name: 'Hà Giang', type: 'Tỉnh' },
        { id: '04', name: 'Cao Bằng', type: 'Tỉnh' },
        { id: '06', name: 'Bắc Kạn', type: 'Tỉnh' },
        { id: '08', name: 'Tuyên Quang', type: 'Tỉnh' },
        { id: '10', name: 'Lào Cai', type: 'Tỉnh' },
        { id: '11', name: 'Yên Bái', type: 'Tỉnh' },
        { id: '19', name: 'Thái Nguyên', type: 'Tỉnh' },
        { id: '20', name: 'Lạng Sơn', type: 'Tỉnh' },
        { id: '24', name: 'Bắc Giang', type: 'Tỉnh' },
        { id: '25', name: 'Phú Thọ', type: 'Tỉnh' },
        { id: '12', name: 'Điện Biên', type: 'Tỉnh' },
        { id: '14', name: 'Lai Châu', type: 'Tỉnh' },
        { id: '15', name: 'Sơn La', type: 'Tỉnh' },
        { id: '17', name: 'Hòa Bình', type: 'Tỉnh' },
        { id: '38', name: 'Thanh Hóa', type: 'Tỉnh' },
        { id: '40', name: 'Nghệ An', type: 'Tỉnh' },
        { id: '42', name: 'Hà Tĩnh', type: 'Tỉnh' },
        { id: '44', name: 'Quảng Bình', type: 'Tỉnh' },
        { id: '45', name: 'Quảng Trị', type: 'Tỉnh' },
        { id: '49', name: 'Quảng Nam', type: 'Tỉnh' },
        { id: '51', name: 'Quảng Ngãi', type: 'Tỉnh' },
        { id: '52', name: 'Bình Định', type: 'Tỉnh' },
        { id: '54', name: 'Phú Yên', type: 'Tỉnh' },
        { id: '56', name: 'Khánh Hòa', type: 'Tỉnh' },
        { id: '58', name: 'Ninh Thuận', type: 'Tỉnh' },
        { id: '60', name: 'Bình Thuận', type: 'Tỉnh' },
        { id: '62', name: 'Kon Tum', type: 'Tỉnh' },
        { id: '64', name: 'Gia Lai', type: 'Tỉnh' },
        { id: '66', name: 'Đắk Lắk', type: 'Tỉnh' },
        { id: '67', name: 'Đắk Nông', type: 'Tỉnh' },
        { id: '68', name: 'Lâm Đồng', type: 'Tỉnh' },
        { id: '70', name: 'Bình Phước', type: 'Tỉnh' },
        { id: '72', name: 'Tây Ninh', type: 'Tỉnh' },
        { id: '74', name: 'Bình Dương', type: 'Tỉnh' },
        { id: '75', name: 'Đồng Nai', type: 'Tỉnh' },
        { id: '77', name: 'Bà Rịa - Vũng Tàu', type: 'Tỉnh' },
        { id: '80', name: 'Long An', type: 'Tỉnh' },
        { id: '82', name: 'Tiền Giang', type: 'Tỉnh' },
        { id: '83', name: 'Bến Tre', type: 'Tỉnh' },
        { id: '84', name: 'Trà Vinh', type: 'Tỉnh' },
        { id: '86', name: 'Vĩnh Long', type: 'Tỉnh' },
        { id: '87', name: 'Đồng Tháp', type: 'Tỉnh' },
        { id: '89', name: 'An Giang', type: 'Tỉnh' },
        { id: '91', name: 'Kiên Giang', type: 'Tỉnh' },
        { id: '93', name: 'Hậu Giang', type: 'Tỉnh' },
        { id: '94', name: 'Sóc Trăng', type: 'Tỉnh' },
        { id: '95', name: 'Bạc Liêu', type: 'Tỉnh' },
        { id: '96', name: 'Cà Mau', type: 'Tỉnh' }
    ],

    // Danh sách Quận/Huyện theo từng tỉnh
    districts: {
        // Hà Nội
        '01': [
            { id: '001', name: 'Quận Ba Đình' },
            { id: '002', name: 'Quận Hoàn Kiếm' },
            { id: '003', name: 'Quận Tây Hồ' },
            { id: '004', name: 'Quận Long Biên' },
            { id: '005', name: 'Quận Cầu Giấy' },
            { id: '006', name: 'Quận Đống Đa' },
            { id: '007', name: 'Quận Hai Bà Trưng' },
            { id: '008', name: 'Quận Hoàng Mai' },
            { id: '009', name: 'Quận Thanh Xuân' },
            { id: '016', name: 'Huyện Sóc Sơn' },
            { id: '017', name: 'Huyện Đông Anh' },
            { id: '018', name: 'Huyện Gia Lâm' },
            { id: '019', name: 'Quận Nam Từ Liêm' },
            { id: '020', name: 'Huyện Thanh Trì' },
            { id: '021', name: 'Quận Bắc Từ Liêm' },
            { id: '250', name: 'Huyện Mê Linh' },
            { id: '268', name: 'Quận Hà Đông' },
            { id: '269', name: 'Thị xã Sơn Tây' },
            { id: '271', name: 'Huyện Ba Vì' },
            { id: '272', name: 'Huyện Phúc Thọ' },
            { id: '273', name: 'Huyện Đan Phượng' },
            { id: '274', name: 'Huyện Hoài Đức' },
            { id: '275', name: 'Huyện Quốc Oai' },
            { id: '276', name: 'Huyện Thạch Thất' },
            { id: '277', name: 'Huyện Chương Mỹ' },
            { id: '278', name: 'Huyện Thanh Oai' },
            { id: '279', name: 'Huyện Thường Tín' },
            { id: '280', name: 'Huyện Phú Xuyên' },
            { id: '281', name: 'Huyện Ứng Hòa' },
            { id: '282', name: 'Huyện Mỹ Đức' }
        ],

        // TP. Hồ Chí Minh
        '79': [
            { id: '760', name: 'Quận 1' },
            { id: '770', name: 'Quận 3' },
            { id: '771', name: 'Quận 4' },
            { id: '772', name: 'Quận 5' },
            { id: '773', name: 'Quận 6' },
            { id: '774', name: 'Quận 7' },
            { id: '775', name: 'Quận 8' },
            { id: '778', name: 'Quận 10' },
            { id: '776', name: 'Quận 11' },
            { id: '777', name: 'Quận 12' },
            { id: '761', name: 'Quận Gò Vấp' },
            { id: '764', name: 'Quận Bình Thạnh' },
            { id: '765', name: 'Quận Tân Bình' },
            { id: '766', name: 'Quận Tân Phú' },
            { id: '767', name: 'Quận Phú Nhuận' },
            { id: '783', name: 'Thành phố Thủ Đức' },
            { id: '768', name: 'Quận Bình Tân' },
            { id: '769', name: 'Huyện Củ Chi' },
            { id: '787', name: 'Huyện Hóc Môn' },
            { id: '785', name: 'Huyện Bình Chánh' },
            { id: '786', name: 'Huyện Nhà Bè' },
            { id: '784', name: 'Huyện Cần Giờ' }
        ],

        // Hải Phòng
        '31': [
            { id: '303', name: 'Quận Hồng Bàng' },
            { id: '304', name: 'Quận Ngô Quyền' },
            { id: '305', name: 'Quận Lê Chân' },
            { id: '306', name: 'Quận Hải An' },
            { id: '307', name: 'Quận Kiến An' },
            { id: '308', name: 'Quận Đồ Sơn' },
            { id: '309', name: 'Quận Dương Kinh' },
            { id: '311', name: 'Huyện Thuỷ Nguyên' },
            { id: '312', name: 'Huyện An Dương' },
            { id: '313', name: 'Huyện An Lão' },
            { id: '314', name: 'Huyện Kiến Thuỵ' },
            { id: '315', name: 'Huyện Tiên Lãng' },
            { id: '316', name: 'Huyện Vĩnh Bảo' },
            { id: '317', name: 'Huyện Cát Hải' },
            { id: '318', name: 'Huyện Bạch Long Vĩ' }
        ],

        // Đà Nẵng
        '48': [
            { id: '490', name: 'Quận Liên Chiểu' },
            { id: '491', name: 'Quận Thanh Khê' },
            { id: '492', name: 'Quận Hải Châu' },
            { id: '493', name: 'Quận Sơn Trà' },
            { id: '494', name: 'Quận Ngũ Hành Sơn' },
            { id: '495', name: 'Quận Cẩm Lệ' },
            { id: '497', name: 'Huyện Hòa Vang' },
            { id: '498', name: 'Huyện Hoàng Sa' }
        ],

        // Cần Thơ
        '92': [
            { id: '916', name: 'Quận Ninh Kiều' },
            { id: '917', name: 'Quận Ô Môn' },
            { id: '918', name: 'Quận Bình Thuỷ' },
            { id: '919', name: 'Quận Cái Răng' },
            { id: '923', name: 'Quận Thốt Nốt' },
            { id: '924', name: 'Huyện Vĩnh Thạnh' },
            { id: '925', name: 'Huyện Cờ Đỏ' },
            { id: '926', name: 'Huyện Phong Điền' },
            { id: '927', name: 'Huyện Thới Lai' }
        ],

        // Huế (Thừa Thiên Huế)
        '46': [
            { id: '474', name: 'Thành phố Huế' },
            { id: '476', name: 'Huyện Phong Điền' },
            { id: '477', name: 'Huyện Quảng Điền' },
            { id: '478', name: 'Huyện Phú Vang' },
            { id: '479', name: 'Thị xã Hương Thủy' },
            { id: '480', name: 'Thị xã Hương Trà' },
            { id: '481', name: 'Huyện A Lưới' },
            { id: '482', name: 'Huyện Phú Lộc' },
            { id: '483', name: 'Huyện Nam Đông' }
        ],

        // Bình Dương
        '74': [
            { id: '718', name: 'Thành phố Thủ Dầu Một' },
            { id: '719', name: 'Huyện Bàu Bàng' },
            { id: '720', name: 'Huyện Dầu Tiếng' },
            { id: '721', name: 'Thị xã Bến Cát' },
            { id: '722', name: 'Huyện Phú Giáo' },
            { id: '723', name: 'Thị xã Tân Uyên' },
            { id: '724', name: 'Thành phố Dĩ An' },
            { id: '725', name: 'Thành phố Thuận An' },
            { id: '726', name: 'Huyện Bắc Tân Uyên' }
        ],

        // Đồng Nai
        '75': [
            { id: '731', name: 'Thành phố Biên Hòa' },
            { id: '732', name: 'Thành phố Long Khánh' },
            { id: '734', name: 'Huyện Tân Phú' },
            { id: '735', name: 'Huyện Vĩnh Cửu' },
            { id: '736', name: 'Huyện Định Quán' },
            { id: '737', name: 'Huyện Trảng Bom' },
            { id: '738', name: 'Huyện Thống Nhất' },
            { id: '739', name: 'Huyện Cẩm Mỹ' },
            { id: '740', name: 'Huyện Long Thành' },
            { id: '741', name: 'Huyện Xuân Lộc' },
            { id: '742', name: 'Huyện Nhơn Trạch' }
        ],

        // Vĩnh Phúc
        '26': [
            { id: '001', name: 'Thành phố Vĩnh Yên' },
            { id: '002', name: 'Thành phố Phúc Yên' },
            { id: '003', name: 'Huyện Bình Xuyên' },
            { id: '004', name: 'Huyện Lập Thạch' },
            { id: '005', name: 'Huyện Sông Lô' },
            { id: '006', name: 'Huyện Tam Dương' },
            { id: '007', name: 'Huyện Tam Đảo' },
            { id: '008', name: 'Huyện Vĩnh Tường' },
            { id: '009', name: 'Huyện Yên Lạc' }
        ],

        // Bắc Ninh
        '27': [
            { id: '001', name: 'Thành phố Bắc Ninh' },
            { id: '002', name: 'Thành phố Từ Sơn' },
            { id: '003', name: 'Thị xã Quế Võ' },
            { id: '004', name: 'Thị xã Thuận Thành' },
            { id: '005', name: 'Huyện Tiên Du' },
            { id: '006', name: 'Huyện Yên Phong' },
            { id: '007', name: 'Huyện Gia Bình' },
            { id: '008', name: 'Huyện Lương Tài' }
        ],

        // Quảng Ninh
        '22': [
            { id: '001', name: 'Thành phố Hạ Long' },
            { id: '002', name: 'Thành phố Móng Cái' },
            { id: '003', name: 'Thành phố Cẩm Phả' },
            { id: '004', name: 'Thành phố Uông Bí' },
            { id: '005', name: 'Thị xã Quảng Yên' },
            { id: '006', name: 'Thị xã Đông Triều' },
            { id: '007', name: 'Huyện Ba Chẽ' },
            { id: '008', name: 'Huyện Bình Liêu' },
            { id: '009', name: 'Huyện Cô Tô' },
            { id: '010', name: 'Huyện Đầm Hà' },
            { id: '011', name: 'Huyện Hải Hà' },
            { id: '012', name: 'Huyện Tiên Yên' },
            { id: '013', name: 'Huyện Vân Đồn' }
        ],

        // Hải Dương
        '30': [
            { id: '001', name: 'Thành phố Hải Dương' },
            { id: '002', name: 'Thành phố Chí Linh' },
            { id: '003', name: 'Thị xã Kinh Môn' },
            { id: '004', name: 'Huyện Ninh Giang' },
            { id: '005', name: 'Huyện Thanh Miện' },
            { id: '006', name: 'Huyện Nam Sách' },
            { id: '007', name: 'Huyện Kim Thành' },
            { id: '008', name: 'Huyện Cẩm Giàng' },
            { id: '009', name: 'Huyện Tứ Kỳ' },
            { id: '010', name: 'Huyện Bình Giang' },
            { id: '011', name: 'Huyện Thanh Hà' },
            { id: '012', name: 'Huyện Gia Lộc' }
        ],

        // Hưng Yên
        '33': [
            { id: '001', name: 'Thành phố Hưng Yên' },
            { id: '002', name: 'Thị xã Mỹ Hào' },
            { id: '003', name: 'Huyện Khoái Châu' },
            { id: '004', name: 'Huyện Yên Mỹ' },
            { id: '005', name: 'Huyện Ân Thi' },
            { id: '006', name: 'Huyện Văn Lâm' },
            { id: '007', name: 'Huyện Văn Giang' },
            { id: '008', name: 'Huyện Kim Động' },
            { id: '009', name: 'Huyện Tiên Lữ' },
            { id: '010', name: 'Huyện Phù Cừ' }
        ],

        // Thái Bình
        '34': [
            { id: '001', name: 'Thành phố Thái Bình' },
            { id: '002', name: 'Huyện Đông Hưng' },
            { id: '003', name: 'Huyện Hưng Hà' },
            { id: '004', name: 'Huyện Kiến Xương' },
            { id: '005', name: 'Huyện Quỳnh Phụ' },
            { id: '006', name: 'Huyện Thái Thụy' },
            { id: '007', name: 'Huyện Tiền Hải' },
            { id: '008', name: 'Huyện Vũ Thư' }
        ],

        // Hà Nam
        '35': [
            { id: '001', name: 'Thành phố Phủ Lý' },
            { id: '002', name: 'Thị xã Duy Tiên' },
            { id: '003', name: 'Thị xã Kim Bảng' },
            { id: '004', name: 'Huyện Bình Lục' },
            { id: '005', name: 'Huyện Lý Nhân' },
            { id: '006', name: 'Huyện Thanh Liêm' }
        ],

        // Nam Định
        '36': [
            { id: '001', name: 'Thành phố Nam Định' },
            { id: '002', name: 'Huyện Giao Thủy' },
            { id: '003', name: 'Huyện Hải Hậu' },
            { id: '004', name: 'Huyện Mỹ Lộc' },
            { id: '005', name: 'Huyện Nam Trực' },
            { id: '006', name: 'Huyện Nghĩa Hưng' },
            { id: '007', name: 'Huyện Trực Ninh' },
            { id: '008', name: 'Huyện Vụ Bản' },
            { id: '009', name: 'Huyện Xuân Trường' },
            { id: '010', name: 'Huyện Ý Yên' }
        ],

        // Ninh Bình
        '37': [
            { id: '001', name: 'Thành phố Ninh Bình' },
            { id: '002', name: 'Thành phố Tam Điệp' },
            { id: '003', name: 'Huyện Gia Viễn' },
            { id: '004', name: 'Huyện Hoa Lư' },
            { id: '005', name: 'Huyện Kim Sơn' },
            { id: '006', name: 'Huyện Nho Quan' },
            { id: '007', name: 'Huyện Yên Khánh' },
            { id: '008', name: 'Huyện Yên Mô' }
        ],

        // Hà Giang
        '02': [
            { id: '001', name: 'Thành phố Hà Giang' },
            { id: '002', name: 'Huyện Bắc Mê' },
            { id: '003', name: 'Huyện Bắc Quang' },
            { id: '004', name: 'Huyện Đồng Văn' },
            { id: '005', name: 'Huyện Hoàng Su Phì' },
            { id: '006', name: 'Huyện Mèo Vạc' },
            { id: '007', name: 'Huyện Quản Bạ' },
            { id: '008', name: 'Huyện Quang Bình' },
            { id: '009', name: 'Huyện Vị Xuyên' },
            { id: '010', name: 'Huyện Xín Mần' },
            { id: '011', name: 'Huyện Yên Minh' }
        ],

        // Cao Bằng
        '04': [
            { id: '001', name: 'Thành phố Cao Bằng' },
            { id: '002', name: 'Huyện Bảo Lạc' },
            { id: '003', name: 'Huyện Bảo Lâm' },
            { id: '004', name: 'Huyện Hà Quảng' },
            { id: '005', name: 'Huyện Trùng Khánh' },
            { id: '006', name: 'Huyện Hạ Lang' },
            { id: '007', name: 'Huyện Hòa An' },
            { id: '008', name: 'Huyện Nguyên Bình' },
            { id: '009', name: 'Huyện Quảng Hòa' },
            { id: '010', name: 'Huyện Thạch An' }
        ],

        // Bắc Kạn
        '06': [
            { id: '001', name: 'Thành phố Bắc Kạn' },
            { id: '002', name: 'Huyện Ba Bể' },
            { id: '003', name: 'Huyện Bạch Thông' },
            { id: '004', name: 'Huyện Chợ Đồn' },
            { id: '005', name: 'Huyện Chợ Mới' },
            { id: '006', name: 'Huyện Na Rì' },
            { id: '007', name: 'Huyện Ngân Sơn' },
            { id: '008', name: 'Huyện Pác Nặm' }
        ],

        // Tuyên Quang
        '08': [
            { id: '001', name: 'Thành phố Tuyên Quang' },
            { id: '002', name: 'Huyện Sơn Dương' },
            { id: '003', name: 'Huyện Yên Sơn' },
            { id: '004', name: 'Huyện Hàm Yên' },
            { id: '005', name: 'Huyện Chiêm Hóa' },
            { id: '006', name: 'Huyện Nà Hang' },
            { id: '007', name: 'Huyện Lâm Bình' }
        ],

        // Lào Cai
        '10': [
            { id: '001', name: 'Thành phố Lào Cai' },
            { id: '002', name: 'Thị xã Sa Pa' },
            { id: '003', name: 'Huyện Bát Xát' },
            { id: '004', name: 'Huyện Bảo Thắng' },
            { id: '005', name: 'Huyện Bảo Yên' },
            { id: '006', name: 'Huyện Mường Khương' },
            { id: '007', name: 'Huyện Si Ma Cai' },
            { id: '008', name: 'Huyện Bắc Hà' },
            { id: '009', name: 'Huyện Văn Bàn' }
        ],

        // Yên Bái
        '11': [
            { id: '001', name: 'Thành phố Yên Bái' },
            { id: '002', name: 'Thị xã Nghĩa Lộ' },
            { id: '003', name: 'Huyện Mù Căng Chải' },
            { id: '004', name: 'Huyện Lục Yên' },
            { id: '005', name: 'Huyện Trạm Tấu' },
            { id: '006', name: 'Huyện Trấn Yên' },
            { id: '007', name: 'Huyện Văn Chấn' },
            { id: '008', name: 'Huyện Văn Yên' },
            { id: '009', name: 'Huyện Yên Bình' }
        ],

        // Thái Nguyên
        '19': [
            { id: '001', name: 'Thành phố Thái Nguyên' },
            { id: '002', name: 'Thành phố Sông Công' },
            { id: '003', name: 'Thành phố Phổ Yên' },
            { id: '004', name: 'Huyện Định Hóa' },
            { id: '005', name: 'Huyện Đồng Hỷ' },
            { id: '006', name: 'Huyện Phú Lương' },
            { id: '007', name: 'Huyện Đại Từ' },
            { id: '008', name: 'Huyện Phú Bình' },
            { id: '009', name: 'Huyện Võ Nhai' }
        ],

        // Lạng Sơn
        '20': [
            { id: '001', name: 'Thành phố Lạng Sơn' },
            { id: '002', name: 'Huyện Tràng Định' },
            { id: '003', name: 'Huyện Bình Gia' },
            { id: '004', name: 'Huyện Văn Lãng' },
            { id: '005', name: 'Huyện Cao Lộc' },
            { id: '006', name: 'Huyện Văn Quan' },
            { id: '007', name: 'Huyện Bắc Sơn' },
            { id: '008', name: 'Huyện Hữu Lũng' },
            { id: '009', name: 'Huyện Chi Lăng' },
            { id: '010', name: 'Huyện Lộc Bình' },
            { id: '011', name: 'Huyện Đình Lập' }
        ],

        // Bắc Giang
        '24': [
            { id: '001', name: 'Thành phố Bắc Giang' },
            { id: '002', name: 'Thị xã Việt Yên' },
            { id: '003', name: 'Thị xã Chũ' },
            { id: '004', name: 'Huyện Hiệp Hòa' },
            { id: '005', name: 'Huyện Lạng Giang' },
            { id: '006', name: 'Huyện Lục Nam' },
            { id: '007', name: 'Huyện Lục Ngạn' },
            { id: '008', name: 'Huyện Sơn Động' },
            { id: '009', name: 'Huyện Tân Yên' },
            { id: '010', name: 'Huyện Yên Dũng' },
            { id: '011', name: 'Huyện Yên Thế' }
        ],

        // Phú Thọ
        '25': [
            { id: '001', name: 'Thành phố Việt Trì' },
            { id: '002', name: 'Thị xã Phú Thọ' },
            { id: '003', name: 'Huyện Đoan Hùng' },
            { id: '004', name: 'Huyện Hạ Hòa' },
            { id: '005', name: 'Huyện Thanh Ba' },
            { id: '006', name: 'Huyện Phù Ninh' },
            { id: '007', name: 'Huyện Lâm Thao' },
            { id: '008', name: 'Huyện Tam Nông' },
            { id: '009', name: 'Huyện Thanh Thủy' },
            { id: '010', name: 'Huyện Cẩm Khê' },
            { id: '011', name: 'Huyện Yên Lập' },
            { id: '012', name: 'Huyện Thanh Sơn' },
            { id: '013', name: 'Huyện Tân Sơn' }
        ],

        // Điện Biên
        '12': [
            { id: '001', name: 'Thành phố Điện Biên Phủ' },
            { id: '002', name: 'Thị xã Mường Lay' },
            { id: '003', name: 'Huyện Mường Nhé' },
            { id: '004', name: 'Huyện Mường Chà' },
            { id: '005', name: 'Huyện Tủa Chùa' },
            { id: '006', name: 'Huyện Tuần Giáo' },
            { id: '007', name: 'Huyện Mường Ảng' },
            { id: '008', name: 'Huyện Điện Biên' },
            { id: '009', name: 'Huyện Điện Biên Đông' },
            { id: '010', name: 'Huyện Nậm Pồ' }
        ],

        // Lai Châu
        '14': [
            { id: '001', name: 'Thành phố Lai Châu' },
            { id: '002', name: 'Huyện Mường Tè' },
            { id: '003', name: 'Huyện Nậm Nhùn' },
            { id: '004', name: 'Huyện Phong Thổ' },
            { id: '005', name: 'Huyện Sìn Hồ' },
            { id: '006', name: 'Huyện Tam Đường' },
            { id: '007', name: 'Huyện Tân Uyên' },
            { id: '008', name: 'Huyện Than Uyên' }
        ],

        // Sơn La
        '15': [
            { id: '001', name: 'Thành phố Sơn La' },
            { id: '002', name: 'Thị xã Mộc Châu' },
            { id: '003', name: 'Huyện Bắc Yên' },
            { id: '004', name: 'Huyện Mai Sơn' },
            { id: '005', name: 'Huyện Mường La' },
            { id: '006', name: 'Huyện Phù Yên' },
            { id: '007', name: 'Huyện Quỳnh Nhai' },
            { id: '008', name: 'Huyện Sông Mã' },
            { id: '009', name: 'Huyện Sốp Cộp' },
            { id: '010', name: 'Huyện Thuận Châu' },
            { id: '011', name: 'Huyện Vân Hồ' },
            { id: '012', name: 'Huyện Yên Châu' }
        ],

        // Hòa Bình
        '17': [
            { id: '001', name: 'Thành phố Hòa Bình' },
            { id: '002', name: 'Huyện Cao Phong' },
            { id: '003', name: 'Huyện Đà Bắc' },
            { id: '004', name: 'Huyện Kim Bôi' },
            { id: '005', name: 'Huyện Lạc Sơn' },
            { id: '006', name: 'Huyện Lạc Thủy' },
            { id: '007', name: 'Huyện Lương Sơn' },
            { id: '008', name: 'Huyện Mai Châu' },
            { id: '009', name: 'Huyện Tân Lạc' },
            { id: '010', name: 'Huyện Yên Thủy' }
        ],

        // Thanh Hóa
        '38': [
            { id: '001', name: 'Thành phố Thanh Hóa' },
            { id: '002', name: 'Thành phố Sầm Sơn' },
            { id: '003', name: 'Thị xã Bỉm Sơn' },
            { id: '004', name: 'Thị xã Nghi Sơn' },
            { id: '005', name: 'Huyện Bá Thước' },
            { id: '006', name: 'Huyện Cẩm Thủy' },
            { id: '007', name: 'Huyện Đông Sơn' },
            { id: '008', name: 'Huyện Hà Trung' },
            { id: '009', name: 'Huyện Hậu Lộc' },
            { id: '010', name: 'Huyện Hoằng Hóa' },
            { id: '011', name: 'Huyện Lang Chánh' },
            { id: '012', name: 'Huyện Mường Lát' },
            { id: '013', name: 'Huyện Nga Sơn' },
            { id: '014', name: 'Huyện Ngọc Lặc' },
            { id: '015', name: 'Huyện Như Thanh' },
            { id: '016', name: 'Huyện Như Xuân' },
            { id: '017', name: 'Huyện Nông Cống' },
            { id: '018', name: 'Huyện Quan Hóa' },
            { id: '019', name: 'Huyện Quan Sơn' },
            { id: '020', name: 'Huyện Quảng Xương' },
            { id: '021', name: 'Huyện Thạch Thành' },
            { id: '022', name: 'Huyện Thiệu Hóa' },
            { id: '023', name: 'Huyện Thọ Xuân' },
            { id: '024', name: 'Huyện Thường Xuân' },
            { id: '025', name: 'Huyện Triệu Sơn' },
            { id: '026', name: 'Huyện Vĩnh Lộc' },
            { id: '027', name: 'Huyện Yên Định' }
        ],

        // Nghệ An
        '40': [
            { id: '001', name: 'Thành phố Vinh' },
            { id: '002', name: 'Thị xã Cửa Lò' },
            { id: '003', name: 'Thị xã Thái Hòa' },
            { id: '004', name: 'Thị xã Hoàng Mai' },
            { id: '005', name: 'Huyện Anh Sơn' },
            { id: '006', name: 'Huyện Con Cuông' },
            { id: '007', name: 'Huyện Diễn Châu' },
            { id: '008', name: 'Huyện Đô Lương' },
            { id: '009', name: 'Huyện Hưng Nguyên' },
            { id: '010', name: 'Huyện Kỳ Sơn' },
            { id: '011', name: 'Huyện Nam Đàn' },
            { id: '012', name: 'Huyện Nghi Lộc' },
            { id: '013', name: 'Huyện Nghĩa Đàn' },
            { id: '014', name: 'Huyện Quế Phong' },
            { id: '015', name: 'Huyện Quỳ Châu' },
            { id: '016', name: 'Huyện Quỳ Hợp' },
            { id: '017', name: 'Huyện Quỳnh Lưu' },
            { id: '018', name: 'Huyện Tân Kỳ' },
            { id: '019', name: 'Huyện Thanh Chương' },
            { id: '020', name: 'Huyện Tương Dương' },
            { id: '021', name: 'Huyện Yên Thành' }
        ],

        // Hà Tĩnh
        '42': [
            { id: '001', name: 'Thành phố Hà Tĩnh' },
            { id: '002', name: 'Thị xã Hồng Lĩnh' },
            { id: '003', name: 'Thị xã Kỳ Anh' },
            { id: '004', name: 'Huyện Cẩm Xuyên' },
            { id: '005', name: 'Huyện Can Lộc' },
            { id: '006', name: 'Huyện Đức Thọ' },
            { id: '007', name: 'Huyện Hương Khê' },
            { id: '008', name: 'Huyện Hương Sơn' },
            { id: '009', name: 'Huyện Kỳ Anh' },
            { id: '010', name: 'Huyện Lộc Hà' },
            { id: '011', name: 'Huyện Nghi Xuân' },
            { id: '012', name: 'Huyện Thạch Hà' },
            { id: '013', name: 'Huyện Vũ Quang' }
        ],

        // Quảng Bình
        '44': [
            { id: '001', name: 'Thành phố Đồng Hới' },
            { id: '002', name: 'Thị xã Ba Đồn' },
            { id: '003', name: 'Huyện Bố Trạch' },
            { id: '004', name: 'Huyện Lệ Thủy' },
            { id: '005', name: 'Huyện Minh Hóa' },
            { id: '006', name: 'Huyện Quảng Ninh' },
            { id: '007', name: 'Huyện Quảng Trạch' },
            { id: '008', name: 'Huyện Tuyên Hóa' }
        ],

        // Quảng Trị
        '45': [
            { id: '001', name: 'Thành phố Đông Hà' },
            { id: '002', name: 'Thị xã Quảng Trị' },
            { id: '003', name: 'Huyện Cam Lộ' },
            { id: '004', name: 'Huyện Cồn Cỏ' },
            { id: '005', name: 'Huyện Đa Krông' },
            { id: '006', name: 'Huyện Gio Linh' },
            { id: '007', name: 'Huyện Hải Lăng' },
            { id: '008', name: 'Huyện Hướng Hóa' },
            { id: '009', name: 'Huyện Triệu Phong' },
            { id: '010', name: 'Huyện Vĩnh Linh' }
        ],

        // Quảng Nam
        '49': [
            { id: '001', name: 'Thành phố Tam Kỳ' },
            { id: '002', name: 'Thành phố Hội An' },
            { id: '003', name: 'Thị xã Điện Bàn' },
            { id: '004', name: 'Huyện Bắc Trà My' },
            { id: '005', name: 'Huyện Duy Xuyên' },
            { id: '006', name: 'Huyện Đại Lộc' },
            { id: '007', name: 'Huyện Đông Giang' },
            { id: '008', name: 'Huyện Hiệp Đức' },
            { id: '009', name: 'Huyện Nam Giang' },
            { id: '010', name: 'Huyện Nam Trà My' },
            { id: '011', name: 'Huyện Nông Sơn' },
            { id: '012', name: 'Huyện Núi Thành' },
            { id: '013', name: 'Huyện Phú Ninh' },
            { id: '014', name: 'Huyện Phước Sơn' },
            { id: '015', name: 'Huyện Quế Sơn' },
            { id: '016', name: 'Huyện Tây Giang' },
            { id: '017', name: 'Huyện Thăng Bình' },
            { id: '018', name: 'Huyện Tiên Phước' }
        ],

        // Quảng Ngãi
        '51': [
            { id: '001', name: 'Thành phố Quảng Ngãi' },
            { id: '002', name: 'Thị xã Đức Phổ' },
            { id: '003', name: 'Huyện Ba Tơ' },
            { id: '004', name: 'Huyện Bình Sơn' },
            { id: '005', name: 'Huyện Lý Sơn' },
            { id: '006', name: 'Huyện Minh Long' },
            { id: '007', name: 'Huyện Mộ Đức' },
            { id: '008', name: 'Huyện Nghĩa Hành' },
            { id: '009', name: 'Huyện Sơn Hà' },
            { id: '010', name: 'Huyện Sơn Tây' },
            { id: '011', name: 'Huyện Sơn Tịnh' },
            { id: '012', name: 'Huyện Trà Bồng' },
            { id: '013', name: 'Huyện Tư Nghĩa' }
        ],

        // Bình Định
        '52': [
            { id: '001', name: 'Thành phố Quy Nhơn' },
            { id: '002', name: 'Thị xã An Nhơn' },
            { id: '003', name: 'Thị xã Hoài Nhơn' },
            { id: '004', name: 'Huyện An Lão' },
            { id: '005', name: 'Huyện Hoài Ân' },
            { id: '006', name: 'Huyện Phù Cát' },
            { id: '007', name: 'Huyện Phù Mỹ' },
            { id: '008', name: 'Huyện Tây Sơn' },
            { id: '009', name: 'Huyện Tuy Phước' },
            { id: '010', name: 'Huyện Vân Canh' },
            { id: '011', name: 'Huyện Vĩnh Thạnh' }
        ],

        // Phú Yên
        '54': [
            { id: '001', name: 'Thành phố Tuy Hòa' },
            { id: '002', name: 'Thị xã Sông Cầu' },
            { id: '003', name: 'Thị xã Đông Hòa' },
            { id: '004', name: 'Huyện Tuy An' },
            { id: '005', name: 'Huyện Tây Hòa' },
            { id: '006', name: 'Huyện Phú Hòa' },
            { id: '007', name: 'Huyện Đồng Xuân' },
            { id: '008', name: 'Huyện Sơn Hòa' },
            { id: '009', name: 'Huyện Sông Hinh' }
        ],

        // Khánh Hòa
        '56': [
            { id: '001', name: 'Thành phố Nha Trang' },
            { id: '002', name: 'Thành phố Cam Ranh' },
            { id: '003', name: 'Thị xã Ninh Hòa' },
            { id: '004', name: 'Huyện Vạn Ninh' },
            { id: '005', name: 'Huyện Diên Khánh' },
            { id: '006', name: 'Huyện Cam Lâm' },
            { id: '007', name: 'Huyện Khánh Vĩnh' },
            { id: '008', name: 'Huyện Khánh Sơn' },
            { id: '009', name: 'Huyện đảo Trường Sa' }
        ],

        // Ninh Thuận
        '58': [
            { id: '001', name: 'Thành phố Phan Rang - Tháp Chàm' },
            { id: '002', name: 'Huyện Ninh Phước' },
            { id: '003', name: 'Huyện Ninh Hải' },
            { id: '004', name: 'Huyện Ninh Sơn' },
            { id: '005', name: 'Huyện Thuận Nam' },
            { id: '006', name: 'Huyện Thuận Bắc' },
            { id: '007', name: 'Huyện Bác Ái' }
        ],

        // Bình Thuận
        '60': [
            { id: '001', name: 'Thành phố Phan Thiết' },
            { id: '002', name: 'Thị xã La Gi' },
            { id: '003', name: 'Huyện Tuy Phong' },
            { id: '004', name: 'Huyện Bắc Bình' },
            { id: '005', name: 'Huyện Hàm Thuận Bắc' },
            { id: '006', name: 'Huyện Hàm Thuận Nam' },
            { id: '007', name: 'Huyện Hàm Tân' },
            { id: '008', name: 'Huyện Tánh Linh' },
            { id: '009', name: 'Huyện Đức Linh' },
            { id: '010', name: 'Huyện Phú Quý' }
        ],

        // Kon Tum
        '62': [
            { id: '001', name: 'Thành phố Kon Tum' },
            { id: '002', name: 'Huyện Đăk Hà' },
            { id: '003', name: 'Huyện Đăk Tô' },
            { id: '004', name: 'Huyện Đăk Glei' },
            { id: '005', name: 'Huyện Sa Thầy' },
            { id: '006', name: 'Huyện Ia H\'Drai' },
            { id: '007', name: 'Huyện Ngọc Hồi' },
            { id: '008', name: 'Huyện Kon Plông' },
            { id: '009', name: 'Huyện Kon Rẫy' },
            { id: '010', name: 'Huyện Tu Mơ Rông' }
        ],

        // Gia Lai
        '64': [
            { id: '001', name: 'Thành phố Pleiku' },
            { id: '002', name: 'Thị xã An Khê' },
            { id: '003', name: 'Thị xã Ayun Pa' },
            { id: '004', name: 'Huyện Chư Păh' },
            { id: '005', name: 'Huyện Chư Prông' },
            { id: '006', name: 'Huyện Chư Pưh' },
            { id: '007', name: 'Huyện Chư Sê' },
            { id: '008', name: 'Huyện Đak Đoa' },
            { id: '009', name: 'Huyện Đak Pơ' },
            { id: '010', name: 'Huyện Đức Cơ' },
            { id: '011', name: 'Huyện Ia Grai' },
            { id: '012', name: 'Huyện Ia Pa' },
            { id: '013', name: 'Huyện Kbang' },
            { id: '014', name: 'Huyện Kông Chro' },
            { id: '015', name: 'Huyện Krông Pa' },
            { id: '016', name: 'Huyện Mang Yang' },
            { id: '017', name: 'Huyện Phú Thiện' }
        ],

        // Đắk Lắk
        '66': [
            { id: '001', name: 'Thành phố Buôn Ma Thuột' },
            { id: '002', name: 'Thị xã Buôn Hồ' },
            { id: '003', name: 'Huyện Krông Ana' },
            { id: '004', name: 'Huyện Ea Kar' },
            { id: '005', name: 'Huyện Krông Búk' },
            { id: '006', name: 'Huyện M\'Đrắk' },
            { id: '007', name: 'Huyện Ea H\'Leo' },
            { id: '008', name: 'Huyện Cư M\'Gar' },
            { id: '009', name: 'Huyện Buôn Đôn' },
            { id: '010', name: 'Huyện Ea Súp' },
            { id: '011', name: 'Huyện Krông Bông' },
            { id: '012', name: 'Huyện Krông Năng' },
            { id: '013', name: 'Huyện Lắk' },
            { id: '014', name: 'Huyện Krông Pắc' },
            { id: '015', name: 'Huyện Cư Kuin' }
        ],

        // Đắk Nông
        '67': [
            { id: '001', name: 'Thành phố Gia Nghĩa' },
            { id: '002', name: 'Huyện Cư Jút' },
            { id: '003', name: 'Huyện Đắk Glong' },
            { id: '004', name: 'Huyện Đắk Mil' },
            { id: '005', name: 'Huyện Đắk R\'Lấp' },
            { id: '006', name: 'Huyện Đắk Song' },
            { id: '007', name: 'Huyện Krông Nô' },
            { id: '008', name: 'Huyện Tuy Đức' }
        ],

        // Lâm Đồng
        '68': [
            { id: '001', name: 'Thành phố Đà Lạt' },
            { id: '002', name: 'Thành phố Bảo Lộc' },
            { id: '003', name: 'Huyện Bảo Lâm' },
            { id: '004', name: 'Huyện Cát Tiên' },
            { id: '005', name: 'Huyện Di Linh' },
            { id: '006', name: 'Huyện Đạ Huoai' },
            { id: '007', name: 'Huyện Đạ Tẻh' },
            { id: '008', name: 'Huyện Đam Rông' },
            { id: '009', name: 'Huyện Đơn Dương' },
            { id: '010', name: 'Huyện Đức Trọng' },
            { id: '011', name: 'Huyện Lạc Dương' },
            { id: '012', name: 'Huyện Lâm Hà' }
        ],

        // Bình Phước
        '70': [
            { id: '001', name: 'Thành phố Đồng Xoài' },
            { id: '002', name: 'Thị xã Phước Long' },
            { id: '003', name: 'Thị xã Bình Long' },
            { id: '004', name: 'Thị xã Chơn Thành' },
            { id: '005', name: 'Huyện Bù Đăng' },
            { id: '006', name: 'Huyện Bù Đốp' },
            { id: '007', name: 'Huyện Bù Gia Mập' },
            { id: '008', name: 'Huyện Đồng Phú' },
            { id: '009', name: 'Huyện Hớn Quản' },
            { id: '010', name: 'Huyện Lộc Ninh' },
            { id: '011', name: 'Huyện Phú Riềng' }
        ],

        // Tây Ninh
        '72': [
            { id: '001', name: 'Thành phố Tây Ninh' },
            { id: '002', name: 'Thị xã Hòa Thành' },
            { id: '003', name: 'Thị xã Trảng Bàng' },
            { id: '004', name: 'Huyện Bến Cầu' },
            { id: '005', name: 'Huyện Châu Thành' },
            { id: '006', name: 'Huyện Dương Minh Châu' },
            { id: '007', name: 'Huyện Gò Dầu' },
            { id: '008', name: 'Huyện Tân Biên' },
            { id: '009', name: 'Huyện Tân Châu' }
        ],

        // Bà Rịa - Vũng Tàu
        '77': [
            { id: '001', name: 'Thành phố Vũng Tàu' },
            { id: '002', name: 'Thành phố Bà Rịa' },
            { id: '003', name: 'Thị xã Phú Mỹ' },
            { id: '004', name: 'Huyện Châu Đức' },
            { id: '005', name: 'Huyện Đất Đỏ' },
            { id: '006', name: 'Huyện Long Điền' },
            { id: '007', name: 'Huyện Xuyên Mộc' },
            { id: '008', name: 'Huyện Côn Đảo' }
        ],

        // Long An
        '80': [
            { id: '001', name: 'Thành phố Tân An' },
            { id: '002', name: 'Thị xã Kiến Tường' },
            { id: '003', name: 'Huyện Bến Lức' },
            { id: '004', name: 'Huyện Cần Đước' },
            { id: '005', name: 'Huyện Cần Giuộc' },
            { id: '006', name: 'Huyện Châu Thành' },
            { id: '007', name: 'Huyện Đức Hòa' },
            { id: '008', name: 'Huyện Đức Huệ' },
            { id: '009', name: 'Huyện Mộc Hóa' },
            { id: '010', name: 'Huyện Tân Hưng' },
            { id: '011', name: 'Huyện Tân Thạnh' },
            { id: '012', name: 'Huyện Tân Trụ' },
            { id: '013', name: 'Huyện Thạnh Hóa' },
            { id: '014', name: 'Huyện Thủ Thừa' },
            { id: '015', name: 'Huyện Vĩnh Hưng' }
        ],

        // Tiền Giang
        '82': [
            { id: '001', name: 'Thành phố Mỹ Tho' },
            { id: '002', name: 'Thị xã Gò Công' },
            { id: '003', name: 'Thị xã Cai Lậy' },
            { id: '004', name: 'Huyện Cái Bè' },
            { id: '005', name: 'Huyện Cai Lậy' },
            { id: '006', name: 'Huyện Châu Thành' },
            { id: '007', name: 'Huyện Chợ Gạo' },
            { id: '008', name: 'Huyện Gò Công Đông' },
            { id: '009', name: 'Huyện Gò Công Tây' },
            { id: '010', name: 'Huyện Tân Phú Đông' },
            { id: '011', name: 'Huyện Tân Phước' }
        ],

        // Bến Tre
        '83': [
            { id: '001', name: 'Thành phố Bến Tre' },
            { id: '002', name: 'Huyện Ba Tri' },
            { id: '003', name: 'Huyện Bình Đại' },
            { id: '004', name: 'Huyện Châu Thành' },
            { id: '005', name: 'Huyện Chợ Lách' },
            { id: '006', name: 'Huyện Giồng Trôm' },
            { id: '007', name: 'Huyện Mỏ Cày Bắc' },
            { id: '008', name: 'Huyện Mỏ Cày Nam' },
            { id: '009', name: 'Huyện Thạnh Phú' }
        ],

        // Trà Vinh
        '84': [
            { id: '001', name: 'Thành phố Trà Vinh' },
            { id: '002', name: 'Thị xã Duyên Hải' },
            { id: '003', name: 'Huyện Càng Long' },
            { id: '004', name: 'Huyện Cầu Kè' },
            { id: '005', name: 'Huyện Cầu Ngang' },
            { id: '006', name: 'Huyện Châu Thành' },
            { id: '007', name: 'Huyện Duyên Hải' },
            { id: '008', name: 'Huyện Tiểu Cần' },
            { id: '009', name: 'Huyện Trà Cú' }
        ],

        // Vĩnh Long
        '86': [
            { id: '001', name: 'Thành phố Vĩnh Long' },
            { id: '002', name: 'Thị xã Bình Minh' },
            { id: '003', name: 'Huyện Bình Tân' },
            { id: '004', name: 'Huyện Long Hồ' },
            { id: '005', name: 'Huyện Mang Thít' },
            { id: '006', name: 'Huyện Tam Bình' },
            { id: '007', name: 'Huyện Trà Ôn' },
            { id: '008', name: 'Huyện Vũng Liêm' }
        ],

        // Đồng Tháp
        '87': [
            { id: '001', name: 'Thành phố Cao Lãnh' },
            { id: '002', name: 'Thành phố Sa Đéc' },
            { id: '003', name: 'Thành phố Hồng Ngự' },
            { id: '004', name: 'Huyện Cao Lãnh' },
            { id: '005', name: 'Huyện Châu Thành' },
            { id: '006', name: 'Huyện Hồng Ngự' },
            { id: '007', name: 'Huyện Lai Vung' },
            { id: '008', name: 'Huyện Lấp Vò' },
            { id: '009', name: 'Huyện Tam Nông' },
            { id: '010', name: 'Huyện Tân Hồng' },
            { id: '011', name: 'Huyện Thanh Bình' },
            { id: '012', name: 'Huyện Tháp Mười' }
        ],

        // An Giang
        '89': [
            { id: '001', name: 'Thành phố Long Xuyên' },
            { id: '002', name: 'Thành phố Châu Đốc' },
            { id: '003', name: 'Thị xã Tân Châu' },
            { id: '004', name: 'Huyện An Phú' },
            { id: '005', name: 'Huyện Châu Phú' },
            { id: '006', name: 'Huyện Châu Thành' },
            { id: '007', name: 'Huyện Chợ Mới' },
            { id: '008', name: 'Huyện Phú Tân' },
            { id: '009', name: 'Huyện Thoại Sơn' },
            { id: '010', name: 'Huyện Tịnh Biên' },
            { id: '011', name: 'Huyện Tri Tôn' }
        ],

        // Kiên Giang
        '91': [
            { id: '001', name: 'Thành phố Rạch Giá' },
            { id: '002', name: 'Thành phố Phú Quốc' },
            { id: '003', name: 'Thị xã Hà Tiên' },
            { id: '004', name: 'Huyện An Biên' },
            { id: '005', name: 'Huyện An Minh' },
            { id: '006', name: 'Huyện Châu Thành' },
            { id: '007', name: 'Huyện Giang Thành' },
            { id: '008', name: 'Huyện Giồng Riềng' },
            { id: '009', name: 'Huyện Gò Quao' },
            { id: '010', name: 'Huyện Hòn Đất' },
            { id: '011', name: 'Huyện Kiên Hải' },
            { id: '012', name: 'Huyện Kiên Lương' },
            { id: '013', name: 'Huyện Tân Hiệp' },
            { id: '014', name: 'Huyện U Minh Thượng' },
            { id: '015', name: 'Huyện Vĩnh Thuận' }
        ],

        // Hậu Giang
        '93': [
            { id: '001', name: 'Thành phố Vị Thanh' },
            { id: '002', name: 'Thành phố Ngã Bảy' },
            { id: '003', name: 'Thị xã Long Mỹ' },
            { id: '004', name: 'Huyện Châu Thành' },
            { id: '005', name: 'Huyện Châu Thành A' },
            { id: '006', name: 'Huyện Long Mỹ' },
            { id: '007', name: 'Huyện Phụng Hiệp' },
            { id: '008', name: 'Huyện Vị Thủy' }
        ],

        // Sóc Trăng
        '94': [
            { id: '001', name: 'Thành phố Sóc Trăng' },
            { id: '002', name: 'Thị xã Ngã Năm' },
            { id: '003', name: 'Thị xã Vĩnh Châu' },
            { id: '004', name: 'Huyện Châu Thành' },
            { id: '005', name: 'Huyện Cù Lao Dung' },
            { id: '006', name: 'Huyện Kế Sách' },
            { id: '007', name: 'Huyện Long Phú' },
            { id: '008', name: 'Huyện Mỹ Tú' },
            { id: '009', name: 'Huyện Mỹ Xuyên' },
            { id: '010', name: 'Huyện Thạnh Trị' },
            { id: '011', name: 'Huyện Trần Đề' }
        ],

        // Bạc Liêu
        '95': [
            { id: '001', name: 'Thành phố Bạc Liêu' },
            { id: '002', name: 'Thị xã Giá Rai' },
            { id: '003', name: 'Huyện Đông Hải' },
            { id: '004', name: 'Huyện Hòa Bình' },
            { id: '005', name: 'Huyện Hồng Dân' },
            { id: '006', name: 'Huyện Phước Long' },
            { id: '007', name: 'Huyện Vĩnh Lợi' }
        ],

        // Cà Mau
        '96': [
            { id: '001', name: 'Thành phố Cà Mau' },
            { id: '002', name: 'Huyện Cái Nước' },
            { id: '003', name: 'Huyện Đầm Dơi' },
            { id: '004', name: 'Huyện Năm Căn' },
            { id: '005', name: 'Huyện Ngọc Hiển' },
            { id: '006', name: 'Huyện Phú Tân' },
            { id: '007', name: 'Huyện Thới Bình' },
            { id: '008', name: 'Huyện Trần Văn Thời' },
            { id: '009', name: 'Huyện U Minh' }
        ]
    }
};

/**
 * Lấy danh sách quận/huyện theo mã tỉnh
 * @param {string} provinceId - Mã tỉnh/thành phố
 * @returns {Array} Danh sách quận/huyện
 */
function getDistrictsByProvince(provinceId) {
    return vietnamAddressData.districts[provinceId] || [];
}

/**
 * Lấy tên tỉnh theo mã
 * @param {string} provinceId - Mã tỉnh/thành phố
 * @returns {string} Tên tỉnh/thành phố
 */
function getProvinceName(provinceId) {
    const province = vietnamAddressData.provinces.find(p => p.id === provinceId);
    return province ? province.name : '';
}

/**
 * Lấy tên quận/huyện theo mã
 * @param {string} provinceId - Mã tỉnh/thành phố
 * @param {string} districtId - Mã quận/huyện
 * @returns {string} Tên quận/huyện
 */
function getDistrictName(provinceId, districtId) {
    const districts = getDistrictsByProvince(provinceId);
    const district = districts.find(d => d.id === districtId);
    return district ? district.name : '';
}
