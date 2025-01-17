@extends('layouts.app') 
@section('content')
    
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Injection
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Giới thiệu: </strong> 
                    <p>Lỗ hổng Injection là một trong những lỗ hổng bảo mật phổ biến và nguy hiểm nhất trong các ứng dụng web. Lỗi này xảy ra khi ứng dụng không kiểm soát hoặc xử lý đúng cách dữ liệu đầu vào của người dùng, cho phép kẻ tấn công "chèn" mã độc vào hệ thống hoặc cơ sở dữ liệu của ứng dụng, từ đó có thể thực thi các hành động không mong muốn. Lỗi Injection có thể xảy ra trên nhiều giao thức và công nghệ khác nhau, nhưng phổ biến nhất là trong các ứng dụng web, cơ sở dữ liệu và hệ thống shell.</p>
                </div>
                <button>
                    <a href="/injection">Go to view</a>
                </button>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    File Upload
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Giới thiệu: </strong> 
                    <p>Lỗ hổng upload file là một loại lỗ hổng bảo mật trong ứng dụng web, nơi người dùng có thể tải lên các tệp không hợp lệ hoặc tệp chứa mã độc (như mã PHP, shell scripts, hoặc virus), và từ đó có thể tấn công hoặc chiếm quyền điều khiển hệ thống. Lỗ hổng này chủ yếu xuất hiện khi ứng dụng không kiểm tra đúng cách các tệp tải lên, từ đó tạo điều kiện cho kẻ tấn công thực thi mã độc trên máy chủ.</p>
                </div>
                <button>
                    <a href="/fileUpload">Go to view</a>
                </button>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Server Site Request Forgery(SSRF)
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Giới thiệu: </strong> 
                    <p>Server Side Request Forgery (SSRF) là một lỗ hổng bảo mật mà trong đó kẻ tấn công có thể gửi yêu cầu HTTP đến một máy chủ (hoặc dịch vụ) mà máy chủ mục tiêu (server) không mong muốn. Mục tiêu của kẻ tấn công là lợi dụng chức năng gửi yêu cầu (request) từ server và thực hiện các hành động có hại, chẳng hạn như truy cập thông tin nội bộ hoặc thực thi các yêu cầu đến các dịch vụ ngoài tầm kiểm soát. Khi một ứng dụng web không kiểm tra hoặc hạn chế đầu vào của người dùng (như URL hoặc địa chỉ IP), kẻ tấn công có thể sử dụng lỗ hổng SSRF để gửi yêu cầu tới các địa chỉ nội bộ mà ứng dụng không có quyền truy cập trực tiếp, từ đó tấn công các dịch vụ bên trong hoặc khai thác các thông tin nhạy cảm.</p>
                </div>
                <button>
                    <a href="/ssrf">Go to view</a>
                </button>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Directory Traversal
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Giới thiệu: </strong>
                    <p>
                        Directory Traversal (hay còn gọi là Path Traversal) là một loại lỗ hổng bảo mật mà qua đó, kẻ tấn công có thể truy cập vào các tệp tin hoặc thư mục nằm ngoài phạm vi được phép của hệ thống, bằng cách "lướt qua" các thư mục cha và truy cập các tệp tin quan trọng hoặc nhạy cảm. Lỗ hổng này xảy ra khi ứng dụng web không kiểm tra và xử lý đúng các đường dẫn tệp tin (file path) do người dùng cung cấp. Kẻ tấn công có thể sửa đổi đầu vào đường dẫn tệp tin để di chuyển lên các thư mục khác (thông qua các ký tự đặc biệt như ../) và truy cập các tệp tin ngoài phạm vi.
                    </p>
                </div>
                <button>
                    <a href="/traversal">Go to view</a>
                </button>
            </div>
        </div>
    </div>
@endsection