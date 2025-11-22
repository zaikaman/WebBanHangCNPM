/**
 * Dữ liệu Tỉnh/Thành phố và Quận/Huyện Việt Nam
 * Cập nhật: 11/2024 - Theo Nghị quyết mới nhất
 */

const vietnamAddressData = {
  // Danh sách 34 tỉnh / thành phố sau sáp nhập (tên mới + đơn vị cũ trong ngoặc)
  provinces: [
    // 6 Thành phố trực thuộc Trung ương
    { id: '01', name: 'Thành phố Hà Nội', type: 'Thành phố Trực thuộc Trung ương' }, // giữ nguyên
    { id: '46', name: 'Thành phố Huế', type: 'Thành phố Trực thuộc Trung ương' }, // giữ nguyên

    { 
      id: '31', 
      name: 'Thành phố Hải Phòng (Hải Phòng cũ, Hải Dương cũ)', 
      type: 'Thành phố Trực thuộc Trung ương' 
    },

    { 
      id: '48', 
      name: 'Thành phố Đà Nẵng (Đà Nẵng cũ, Quảng Nam cũ)', 
      type: 'Thành phố Trực thuộc Trung ương' 
    },

    { 
      id: '79', 
      name: 'Thành phố Hồ Chí Minh (TP. Hồ Chí Minh cũ, Bà Rịa - Vũng Tàu cũ, Bình Dương cũ)', 
      type: 'Thành phố Trực thuộc Trung ương' 
    },

    { 
      id: '92', 
      name: 'Thành phố Cần Thơ (Cần Thơ cũ, Sóc Trăng cũ, Hậu Giang cũ)', 
      type: 'Thành phố Trực thuộc Trung ương' 
    },

    // 9 tỉnh giữ nguyên địa giới
    { id: '04', name: 'Cao Bằng', type: 'Tỉnh' },
    { id: '12', name: 'Điện Biên', type: 'Tỉnh' },
    { id: '42', name: 'Hà Tĩnh', type: 'Tỉnh' },
    { id: '14', name: 'Lai Châu', type: 'Tỉnh' },
    { id: '20', name: 'Lạng Sơn', type: 'Tỉnh' },
    { id: '40', name: 'Nghệ An', type: 'Tỉnh' },
    { id: '22', name: 'Quảng Ninh', type: 'Tỉnh' },
    { id: '38', name: 'Thanh Hóa', type: 'Tỉnh' },
    { id: '15', name: 'Sơn La', type: 'Tỉnh' },

    // 1 tỉnh mới Tuyên Quang (gộp Tuyên Quang & Hà Giang)
    { 
      id: '08', 
      name: 'Tuyên Quang (Tuyên Quang cũ, Hà Giang cũ)', 
      type: 'Tỉnh' 
    },

    // Các tỉnh mới hình thành sau sáp nhập
    { 
      id: '10', 
      name: 'Lào Cai (Lào Cai cũ, Yên Bái cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '19', 
      name: 'Thái Nguyên (Thái Nguyên cũ, Bắc Kạn cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '25', 
      name: 'Phú Thọ (Phú Thọ cũ, Vĩnh Phúc cũ, Hòa Bình cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '27', 
      name: 'Bắc Ninh (Bắc Ninh cũ, Bắc Giang cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '33', 
      name: 'Hưng Yên (Hưng Yên cũ, Thái Bình cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '37', 
      name: 'Ninh Bình (Ninh Bình cũ, Hà Nam cũ, Nam Định cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '45', 
      name: 'Quảng Trị (Quảng Trị cũ, Quảng Bình cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '51', 
      name: 'Quảng Ngãi (Quảng Ngãi cũ, Kon Tum cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '64', 
      name: 'Gia Lai (Gia Lai cũ, Bình Định cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '56', 
      name: 'Khánh Hòa (Khánh Hòa cũ, Ninh Thuận cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '68', 
      name: 'Lâm Đồng (Lâm Đồng cũ, Đắk Nông cũ, Bình Thuận cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '66', 
      name: 'Đắk Lắk (Đắk Lắk cũ, Phú Yên cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '75', 
      name: 'Đồng Nai (Đồng Nai cũ, Bình Phước cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '72', 
      name: 'Tây Ninh (Tây Ninh cũ, Long An cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '86', 
      name: 'Vĩnh Long (Vĩnh Long cũ, Bến Tre cũ, Trà Vinh cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '87', 
      name: 'Đồng Tháp (Đồng Tháp cũ, Tiền Giang cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '96', 
      name: 'Cà Mau (Cà Mau cũ, Bạc Liêu cũ)', 
      type: 'Tỉnh' 
    },

    { 
      id: '89', 
      name: 'An Giang (An Giang cũ, Kiên Giang cũ)', 
      type: 'Tỉnh' 
    }
  ],

  // districts giữ nguyên như bạn đã khai báo
  districts: {
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
