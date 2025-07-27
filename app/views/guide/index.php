<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<style>

   
    .fa-lightbulb{
        color: yellow;
    }
    .fa-box{
        color: purple;
    }

    .cta-button {
    background: linear-gradient(to right, #4e54c8, #8f94fb);
    color: white;
    font-size: 1.25rem;
    padding: 14px 30px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none;
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
}

</style>

<main>
    <section class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3"> Cẩm Nang Toàn Diện</h1>
            <p class="lead mb-0" style="font-size: 25px;">
                Chào mừng bạn đến với thế giới đầy màu sắc của các thiết bị công nghệ và mô hình sưu tầm!
                Cẩm nang này sẽ giúp bạn khám phá những kiến thức cơ bản về bàn phím cơ, tai nghe và phụ kiện đi kèm.
            </p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm p-3 sticky-top" style="top: 100px; z-index: 100;">
                    <h5 class="card-title mb-3">Mục lục nội dung <i class="bi bi-list-nested ms-1"></i></h5>
                    <ul class="list-unstyled fw-bold">
                        <li class="mb-2"><a href="#intro" class="text-decoration-none text-dark"><i class="fas fa-regular fa-circle me-2 text-primary"></i>Giới thiệu chung về Gear</a></li>
                        <li class="mb-2"><a href="#keyboard" class="text-decoration-none text-dark"><i class="fas fa-light fa-keyboard me-2 text-info"></i>Bàn phím cơ là gì?</a></li>
                        <li class="mb-2"><a href="#headphones" class="text-decoration-none text-dark"><i class="fas fa-headphones me-2 text-success"></i>Tai nghe là gì?</a></li>
                        <li class="mb-2"><a href="#mouse" class="text-decoration-none text-dark"><i class="fas fa-mouse me-2 text-warning"></i>Chuột Gaming/Văn phòng</a></li> 
                        <li class="mb-2"><a href="#monitor" class="text-decoration-none text-dark"><i class="fas fa-display me-2 text-danger"></i>Màn hình hiển thị</a></li> 
                        <li class="mb-2"><a href="#figure" class="text-decoration-none text-dark"><i class="fas fa-street-view me-2 text-secondary"></i>Mô hình Figure là gì?</a></li>
                        <li class="mb-2"><a href="#accessories" class="text-decoration-none text-dark"><i class="fas fa-box me-2 text-purple"></i>Phụ kiện Gear & Setup</a></li>
                        <li class="mb-2"><a href="#advice" class="text-decoration-none text-dark"><i class="fas fa-lightbulb me-2 text-yellow"></i>Lời khuyên chọn Gear</a></li> </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <section id="intro" class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h3 class="mb-3 text-primary"><i class="fas fa-regular fa-circle me-2 text-primary"></i>Gear là gì và tại sao lại quan trọng?</h3>
                    <p>
                        "Gear" là thuật ngữ chung chỉ các thiết bị, phụ kiện công nghệ hoặc vật phẩm sưu tầm giúp nâng cao trải nghiệm sử dụng máy tính, chơi game, giải trí, hoặc thể hiện cá tính của bạn. Trong một thế giới số hóa, việc sở hữu "gear" phù hợp không chỉ giúp công việc hiệu quả hơn mà còn mang lại niềm vui, sự thoải mái và thể hiện phong cách riêng.
                    </p>
                    <p>
                        Đối với người mới bắt đầu, việc lựa chọn "gear" có thể khá bối rối. Cẩm nang này sẽ giúp bạn làm quen với các loại "gear" phổ biến, từ đó đưa ra những lựa chọn thông minh và phù hợp nhất với nhu cầu cá nhân.
                    </p>
                </section>

                <section id="keyboard" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-info"><i class="fas fa-light fa-keyboard me-2 text-info"></i>Bàn phím cơ là gì?</h3>
                    <p>
                        Bàn phím cơ (Mechanical Keyboard) là loại bàn phím sử dụng các công tắc cơ học (mechanical switches) riêng biệt cho từng phím, thay vì lớp đệm cao su chung như bàn phím thông thường. Điều này mang lại cảm giác gõ khác biệt rõ rệt, độ bền vượt trội và khả năng tùy biến cao.
                    </p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Các loại Switch phổ biến:</h5>
                            <ul>
                                <li style="text-align:justify"><i class="bi bi-circle-fill text-danger me-2"></i><strong>Red switch (Linear):</strong> Gõ nhẹ, êm ái, không có tiếng click, không có khấc phản hồi. Phù hợp cho chơi game tốc độ và gõ văn bản nhẹ nhàng.</li>
                                <li style="text-align:justify"><i class="bi bi-circle-fill text-primary me-2"></i><strong>Blue switch (Clicky):</strong> Có tiếng "click" rõ ràng và khấc phản hồi tactile khi nhấn. Thích hợp cho người gõ văn bản thích cảm giác "gõ" phím.</li>
                                <li style="text-align:justify"><i class="bi bi-circle-fill text-brown me-2"></i><strong>Brown switch (Tactile):</strong> Có khấc phản hồi tactile nhưng không có tiếng click. Là sự cân bằng giữa Red và Blue, phù hợp cho cả gõ văn bản và chơi game.</li>
                                <li style="text-align:justify"><i class="bi bi-circle-fill text-secondary me-2"></i><strong>Black switch (Linear nặng):</strong> Tương tự Red nhưng lực nhấn nặng hơn. Thường được ưa chuộng bởi game thủ muốn tránh gõ nhầm.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Các kiểu Layout (Bố cục) thông dụng:</h5>
                            <ul>
                                <li style="text-align:justify"><i class="bi bi-grid-fill me-2"></i><strong>Full-size (104/108 phím):</strong> Đầy đủ bàn phím số, hàng F-key. Phù hợp cho công việc nhập liệu, lập trình.</li>
                                <li style="text-align:justify"><i class="bi bi-grid me-2"></i><strong>Tenkeyless (TKL - 87/88 phím):</strong> Bỏ đi cụm phím số. Gọn gàng hơn Full-size, vẫn giữ các phím chức năng.</li>
                                <li style="text-align:justify"><i class="bi bi-grid-3x3-gap-fill me-2"></i><strong>60% (61/64 phím):</strong> Rất nhỏ gọn, loại bỏ phím số, hàng F-key, và cụm điều hướng. Phù hợp cho người dùng muốn tối giản không gian hoặc hay di chuyển.</li>
                                <li style="text-align:justify"><i class="bi bi-grid-fill me-2"></i><strong>75%, 65%, 96%, 1800-compact:</strong> Các layout nhỏ gọn hơn Full-size nhưng vẫn giữ lại phần lớn phím chức năng.</li>
                            </ul>
                        </div>
                    </div>
                    <p>
                        <strong>  Góp ý: Lựa chọn bàn phím cơ phụ thuộc vào nhu cầu sử dụng (chơi game, gõ văn bản, lập trình) và sở thích cá nhân về cảm giác gõ. Hãy thử trải nghiệm các loại switch khác nhau trước khi quyết định. </strong>
                    </p>
                    </section>

                <section id="headphones" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-success"><i class="fas fa-headphones me-2 text-success"></i> Tai nghe là gì và các loại phổ biến?</h3>
                    <p>
                        Tai nghe là thiết bị âm thanh cho phép bạn nghe âm thanh từ một nguồn phát mà không làm ảnh hưởng đến người xung quanh. Chúng là "người bạn" không thể thiếu cho việc nghe nhạc, chơi game, xem phim, học tập và làm việc trực tuyến.
                    </p>
                    <h5>Các loại Tai nghe chính:</h5>
                    <ul>
                        <li><i class="bi bi-earbuds me-2"></i><strong>In-ear (Tai nghe nhét tai):</strong> Nhỏ gọn, dễ mang theo, thường đi kèm nhiều kích cỡ nút tai để phù hợp với tai người dùng, giúp cách âm tốt. Phù hợp cho người thường xuyên di chuyển.</li>
                        <li><i class="bi bi-headset me-2"></i><strong>Over-ear (Tai nghe chụp tai):</strong> Trùm kín tai, mang lại trải nghiệm âm thanh sống động, âm trầm sâu và thường thoải mái hơn khi đeo trong thời gian dài. Thích hợp cho game thủ, người nghe nhạc chuyên nghiệp.</li>
                        <li><i class="bi bi-earbuds-fill me-2"></i><strong>On-ear (Tai nghe ốp tai):</strong> Nằm trên vành tai, nhỏ gọn hơn Over-ear nhưng vẫn mang lại chất lượng âm thanh tốt.</li>
                    </ul>
                    <h5>Công nghệ kết nối & Tính năng đặc biệt:</h5>
                    <ul>
                        <li><i class="bi bi-bluetooth me-2"></i><strong>Bluetooth (Không dây):</strong> Tiện lợi cho việc di chuyển, học online, làm việc từ xa. Đảm bảo độ trễ thấp cho game thủ.</li>
                        <li><i class="bi bi-mic me-2"></i><strong>Có dây:</strong> Ổn định, chất lượng âm thanh thường tốt hơn, không cần lo lắng về pin.</li>
                        <li><i class="bi bi-volume-mute me-2"></i><strong>Chống ồn chủ động (ANC):</strong> Loại bỏ tạp âm môi trường, lý tưởng khi làm việc, học tập hoặc di chuyển ở nơi đông người.</li>
                        <li><i class="bi bi-controller me-2"></i><strong>Tai nghe Gaming:</strong> Thường có microphone chất lượng cao, âm thanh vòm ảo (Virtual Surround Sound) giúp định vị kẻ địch tốt hơn trong game.</li>
                    </ul>
                    <p>
                        <strong>  Góp ý: Chọn tai nghe dựa trên mục đích sử dụng (nghe nhạc, chơi game, đàm thoại), sở thích về kiểu dáng (nhét tai, chụp tai), và các tính năng phụ trợ (chống ồn, không dây). </strong>
                    </p>
                    </section>

                <section id="mouse" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-warning"><i class="fas fa-mouse me-2 text-warning"></i>Chuột Gaming / Văn phòng là gì?</h3>
                    <p>
                        Chuột máy tính là thiết bị ngoại vi không thể thiếu, giúp bạn tương tác với máy tính. Ngày nay, chuột được phân loại rõ ràng hơn theo mục đích sử dụng: chuột gaming chuyên biệt cho game thủ và chuột văn phòng tối ưu cho công việc hàng ngày.
                    </p>
                    <h5>Chuột Gaming:</h5>
                    <ul>
                        <li><i class="bi bi-arrow-through-heart-fill me-2"></i><strong>Độ chính xác (DPI/CPI):</strong> Cao, có thể điều chỉnh linh hoạt, cho phép di chuyển con trỏ nhanh và chính xác trên màn hình.</li>
                        <li><i class="bi bi-hourglass-split me-2"></i><strong>Tốc độ phản hồi (Polling Rate):</strong> Thấp (1ms), đảm bảo độ trễ gần như bằng không giữa thao tác tay và phản hồi trên màn hình.</li>
                        <li><i class="bi bi-joystick me-2"></i><strong>Nút bấm:</strong> Số lượng nút nhiều hơn, có thể gán macro, phù hợp cho các game phức tạp.</li>
                        <li><i class="bi bi-lightning-fill me-2"></i><strong>Kết nối:</strong> Cả có dây và không dây, nhưng chuột không dây gaming cao cấp thường có công nghệ riêng để giảm độ trễ.</li>
                        <li><i class="bi bi-lightbulb me-2"></i><strong>Thiết kế:</strong> Thường có đèn RGB, thiết kế công thái học để cầm nắm thoải mái trong thời gian dài.</li>
                    </ul>
                    <h5>Chuột Văn phòng:</h5>
                    <ul>
                        <li><i class="bi bi-battery-charging me-2"></i><strong>Tiện lợi:</strong> Ưu tiên kết nối không dây (Bluetooth, USB receiver), thời lượng pin dài.</li>
                        <li><i class="bi bi-person-fill-check me-2"></i><strong>Thoải mái:</strong> Thiết kế công thái học đơn giản, dễ cầm nắm cho đa số người dùng.</li>
                        <li><i class="bi bi-clipboard-data-fill me-2"></i><strong>Chức năng:</strong> Ít nút hơn, tập trung vào các chức năng cơ bản như cuộn, click.</li>
                        <li><i class="bi bi-lightbulb-off-fill me-2"></i><strong>Tính năng khác:</strong> Ít đèn LED, không có phần mềm tùy chỉnh phức tạp.</li>
                    </ul>
                     <p>
                        <strong>  Góp ý: Chọn chuột gaming nếu bạn là một game thủ nghiêm túc. Với công việc văn phòng, một con chuột không dây tiện dụng, thoải mái sẽ là lựa chọn tốt.</strong>
                    </p>
                    </section>

                <section id="monitor" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-danger"><i class="fas fa-display me-2 text-danger"></i>Màn hình hiển thị là gì?</h3>
                    <p>
                        Màn hình hiển thị (Monitor) là thiết bị cho phép bạn xem nội dung từ máy tính. Đối với game thủ và người làm việc sáng tạo, màn hình là một phần cực kỳ quan trọng để tối ưu trải nghiệm.
                    </p>
                    <h5>Các yếu tố cần quan tâm:</h5>
                    <ul>
                        <li><i class="fa-solid fa-circle-dot me-2"></i><strong>Kích thước & Độ phân giải:</strong> Kích thước lớn hơn cho trải nghiệm sống động, độ phân giải cao (Full HD, 2K, 4K) cho hình ảnh sắc nét.</li>
                        <li><i class="fas fa-light fa-rotate me-2"></i><strong>Tần số quét (Refresh Rate):</strong> Quan trọng cho game thủ. Tần số quét cao (75Hz, 120Hz, 144Hz, 240Hz+) giúp hình ảnh mượt mà hơn, đặc biệt trong game hành động nhanh.</li>
                        <li><i class="fas fa-regular fa-hourglass-half me-2"></i><strong>Thời gian phản hồi (Response Time):</strong> Quan trọng cho game thủ. Thời gian phản hồi thấp (1ms GtG) giúp loại bỏ hiện tượng bóng ma (ghosting).</li>
                        <li><i class="fas fa-regular fa-desktop me-2"></i><strong>Tấm nền:</strong>
                            <ul>
                                <li><strong>IPS:</strong> Màu sắc chính xác, góc nhìn rộng, phù hợp cho thiết kế đồ họa và giải trí tổng thể.</li>
                                <li><strong>VA:</strong> Tỷ lệ tương phản cao, màu đen sâu, phù hợp xem phim và chơi game.</li>
                                <li><strong>TN:</strong> Thời gian phản hồi cực nhanh, giá thành rẻ, nhưng màu sắc và góc nhìn kém hơn.</li>
                            </ul>
                        </li>
                        <li><i class="fa-solid fa-bezier-curve me-2"></i><strong>Công nghệ đồng bộ hóa khung hình (FreeSync/G-Sync):</strong> Giúp loại bỏ hiện tượng xé hình (tearing) và giật lag (stuttering) khi chơi game.</li>
                    </ul>
                    <p>
                        <strong>  Góp ý:  Xác định rõ nhu cầu sử dụng chính (gaming, thiết kế, công việc văn phòng) để chọn màn hình có các thông số phù hợp.</strong>
                    </p>
                    </section>

                <section id="figure" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-secondary"><i class="fas fa-street-view me-2 text-secondary"></i>Mô hình Figure là gì?</h3>
                    <p>
                        Mô hình figure (hoặc figurine) là những tác phẩm nghệ thuật thu nhỏ, mô phỏng chính xác các nhân vật từ anime, manga, game, phim ảnh hoặc truyện tranh. Đây là một thú vui sưu tầm và trưng bày phổ biến, thu hút mọi lứa tuổi bởi sự đa dạng, tinh xảo và giá trị nghệ thuật của chúng.
                    </p>
                    <h5>Các dòng Figure phổ biến:</h5>
                    <ul>
                        <li><i class="bi bi-universal-access-circle me-2"></i><strong>Figma:</strong> Các mô hình có khớp cử động linh hoạt, cho phép người chơi thay đổi nhiều tư thế khác nhau. Thường đi kèm với nhiều phụ kiện và biểu cảm khuôn mặt.</li>
                        <li><i class="bi bi-emoji-smile me-2"></i><strong>Nendoroid:</strong> Đặc trưng bởi thiết kế "chibi" đáng yêu với phần đầu to, cơ thể nhỏ. Chiều cao khoảng 10cm, có khớp và phụ kiện dễ thương.</li>
                        <li><i class="bi bi-person-walking me-2"></i><strong>Action Figure:</strong> Dòng mô hình hành động có khớp, thường tập trung vào chi tiết và khả năng tạo dáng, tái hiện các cảnh chiến đấu.</li>
                        <li><i class="bi bi-palette me-2"></i><strong>Scale Figure (Fixed-pose):</strong> Các mô hình được điêu khắc với một tư thế cố định, tập trung vào độ chân thực, chi tiết tinh xảo và chất lượng sơn. Thường có tỉ lệ (scale) nhất định so với nhân vật gốc (ví dụ 1/7, 1/8).</li>
                        <li><i class="bi bi-puzzle-fill me-2"></i><strong>Garage Kit:</strong> Các bộ mô hình chưa lắp ráp và chưa sơn, dành cho những người có kinh nghiệm muốn tự tay hoàn thiện.</li>
                    </ul>
                     <p>
                        <strong>  Góp ý:  Mỗi mô hình đều trải qua quá trình điêu khắc thủ công hoặc kỹ thuật số, đúc nhựa (PVC/ABS), sau đó được sơn màu thủ công tỉ mỉ để đạt được độ chân thực cao nhất, giống như một tác phẩm nghệ thuật thu nhỏ.</strong>
                    </p>
                    </section>

                <section id="accessories" class="mb-5 p-4 border rounded shadow-sm">
                    <h3 class="mb-3 text-purple"><i class="fas fa-box me-2 text-purple"></i>Phụ kiện Gear & Setup là gì?</h3>
                    <p>
                        Phụ kiện gear là những món đồ nhỏ nhưng cực kỳ hữu ích, giúp tăng cường trải nghiệm sử dụng, làm đẹp góc làm việc/chơi game, hoặc bảo vệ các thiết bị giá trị của bạn. Đây là những "điểm nhấn" giúp bộ sưu tập của bạn trở nên hoàn hảo hơn.
                    </p>
                    <ul>
                        <li><i class="bi bi-key-fill me-2"></i><strong>Móc khóa (Keychain):</strong> Thường là phiên bản thu nhỏ của nhân vật, vũ khí hoặc biểu tượng trong game/anime. Dùng để trang trí balo, chìa khóa, hoặc gắn vào bàn phím cơ.</li>
                        <li><i class="bi bi-stand me-2"></i><strong>Giá đỡ tai nghe/figure:</strong> Giúp tai nghe/figure được trưng bày gọn gàng, tránh va đập, trầy xước và giữ được dáng vẻ ban đầu.</li>
                        <li><i class="bi bi-square-fill me-2"></i><strong>Deskmat/Mousepad lớn:</strong> Tấm lót bàn phím và chuột cỡ lớn, không chỉ bảo vệ bề mặt bàn mà còn là một yếu tố trang trí quan trọng, thể hiện cá tính với nhiều họa tiết độc đáo.</li>
                        <li><i class="bi bi-lightning-charge-fill me-2"></i><strong>Dây rút/Kẹp quản lý cáp:</strong> Giúp sắp xếp dây điện gọn gàng, tránh rối rắm, tăng tính thẩm mỹ và an toàn cho góc làm việc.</li>
                        <li><i class="bi bi-usb-drive-fill me-2"></i><strong>Hub USB/Docking Station:</strong> Mở rộng cổng kết nối, giúp dễ dàng cắm nhiều thiết bị ngoại vi cùng lúc.</li>
                        <li><i class="bi bi-tools me-2"></i><strong>Bộ vệ sinh Gear:</strong> Bao gồm cọ, khăn microfiber, dung dịch vệ sinh để giữ cho thiết bị luôn sạch sẽ và bền đẹp.</li>
                    </ul>
                     <p>
                        <strong>  Góp ý: Đừng bỏ qua các phụ kiện! Chúng có thể "nâng tầm" không gian làm việc/giải trí của bạn lên một đẳng cấp mới với chi phí tương đối phải chăng.</strong>
                    </p>
                    </section>

                <section id="advice" class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h3 class="mb-3 text-yellow"><i class="fas fa-lightbulb me-2 text-yellow"></i>Lời khuyên khi chọn mua Gear</h3>
                    <ol>
                        <li class="mb-3">
                            <strong>Xác định nhu cầu:</strong> Bạn mua Gear để làm gì? Chơi game, làm việc, học tập hay chỉ đơn giản là trưng bày? Nhu cầu sẽ quyết định loại Gear phù hợp nhất.
                        </li>
                        <li class="mb-3">
                            <strong>Ngân sách:</strong> Đặt ra một khoảng ngân sách rõ ràng. Thị trường Gear rất rộng lớn, từ bình dân đến cao cấp, có rất nhiều lựa chọn phù hợp với túi tiền của bạn.
                        </li>
                        <li class="mb-3">
                            <strong>Tìm hiểu và so sánh:</strong> Đừng ngại đọc các bài đánh giá, xem video review và so sánh các sản phẩm khác nhau. Cộng đồng chơi Gear rất đông đảo và sẵn lòng chia sẻ kinh nghiệm.
                        </li>
                        <li class="mb-3">
                            <strong>Thử trực tiếp (nếu có thể):</strong> Đối với bàn phím cơ hay tai nghe, cảm giác trải nghiệm trực tiếp là rất quan trọng. Nếu có cơ hội, hãy đến các cửa hàng để thử sản phẩm.
                        </li>
                        <li class="mb-3">
                            <strong>Chính sách bảo hành & hỗ trợ:</strong> Mua hàng tại các cửa hàng uy tín, có chính sách bảo hành rõ ràng và dịch vụ hỗ trợ khách hàng tốt để yên tâm sử dụng.
                        </li>
                    </ol>
                    <p>
                        Chúng tôi hy vọng cẩm nang này đã cung cấp cho bạn những thông tin hữu ích đầu tiên trên hành trình khám phá thế giới "Gear".
                    </p>
                </section>

                <div class="text-center mt-5">
                    <p class="fs-5 mb-4">
                        <i class="bi bi-hand-thumbs-up-fill text-primary me-2"></i>
                        Bạn đã sẵn sàng nâng cấp trải nghiệm của mình?
                    </p>
                    <a href="<?= BASE_URL ?>/product" 
                    class="cta-button <?= $current_page == 'product.php' ? 'active' : '' ?>">
                        Khám Phá Ngay
                    </a>
                </div>

            </div>
        </div>
    </div>
</main>


<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
