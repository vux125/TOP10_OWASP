# *DEMO LỖ HỔNG WEB*

## **1. Injection**
### ***a. Operation System Command Injection***
Giao diện trang chứa OS Command Injection

![image](https://github.com/user-attachments/assets/c5cab8ea-c8e6-4f3d-bd30-920c8ae5e2a0)

Chúng ta nhập một domain vào input, ở đây chúng ta nhập google.com:

![image](https://github.com/user-attachments/assets/e9c296de-8ef9-4bc9-818a-63e4923cfd5f)

Đây là kết quả của câu lệnh nslookup cho ra thông tin về một domain.
Ta cùng xem code:

![image](https://github.com/user-attachments/assets/d7026925-aa84-4bc5-b5e8-d3b647a648db)

Để lọc dữ liệu đầu vào, đoạn code dùng blacklist $ban nhưng ta thấy danh sách không thực sự đầy đủ, ta hoàn toàn có thể khai thác điều này để chèn lệnh vào, ta có thể lợi dụng lệnh “du -a /” để hiển thị dung lượng của từng tệp và thư mục con:

![image](https://github.com/user-attachments/assets/885452a3-0b9c-45d0-82a8-10913cb6cac9)

Ta cũng có thể sử dụng lệnh “head” thay thế cho lệnh “cat” đọc thông tin “file /etc/passwd” như sau “facebook.com; head /etc/passwd”:

![image](https://github.com/user-attachments/assets/06b29fd0-efae-4cb1-92fc-7d4f35ba6324)

Bên cạnh việc không sử dụng các lệnh trong blacklist, ta còn có thể lợi dụng việc không kiểm tra hoàn toàn input:

![image](https://github.com/user-attachments/assets/87504681-48cf-4074-86ab-e41bb766c953)

Ta dùng các lệnh như bình thường và viết liền “facebook.com;cat /etc/passwd”:

![image](https://github.com/user-attachments/assets/813867ee-9ec6-4878-84e7-31314fd417cb)

⇒ Cách khắc phục:
	Dùng escapeshellarg() hoặc escapeshellcmd() để lọc dữ liệu đầu vào.

### ***b. Sql Injection In-Band(Union Based)***
Đây là giao diện của trang:

![image](https://github.com/user-attachments/assets/ebaf7144-0693-4f80-8ae9-913a01a1f752)

Bấm vào BUY bất kỳ 1 items nào, ta để ý param id trên url:

![image](https://github.com/user-attachments/assets/bd16604c-7e47-4e62-8b21-a846f9e944ab)

Sẽ ra sao nếu ta nhập “id” không đơn giản chỉ là 1, liệu có lỗi gì sau ra không khi chúng ta tiêm các lệnh sql vào, đọc code:

![image](https://github.com/user-attachments/assets/92a1e123-ea87-4a9d-bb87-1bab1abf9eea)

“id” là một untrusted data nhưng được truyền trực tiếp vào câu lệnh SQL để thực hiện mà không lọc, ta hoàn toàn có thể tiêm lệnh sql ở đây.
Ý tưởng ở đây là dùng UNION nhưng chúng ta chưa xác định được số cột trong bảng products và các bảng có trong database.
Xác định số cột trong bảng products ta dùng ORDER BY dựa trên thuật toán tìm kiếm nhị phân để giảm thiểu request sai gửi lên server.
Ta thử với 16 và không được điều đó cho thấy rằng số cột nhỏ hơn 16:

![image](https://github.com/user-attachments/assets/92f339e4-cdd1-4e38-8ccc-a0a028db3afc)

Thử với 8 có trả về kết quả ⇒ số cột nằm từ 8 đến nhỏ hơn 16:

![image](https://github.com/user-attachments/assets/b24a2766-b2a4-48a7-b243-da5cc2e4bb96)

Tiếp tục thử ta tìm được số cột của bảng products là 10 cột
Xác định các bảng trong cơ sở dữ liệu hiện tại ta sẽ kết hợp UNION cùng với dùng hàm GROUP_CONCAT  dùng để nối các giá trị thành một chuỗi và lợi dụng database information_schema có trong mysql để tìm tên các bảng:

![image](https://github.com/user-attachments/assets/21d6b970-2a09-4326-8633-a0877c9ddc8c)

Ta tìm được các bảng trong database hiện tại là: comments, failed_jobs, migrations, password_reset_tokens, personal_access_tokens, products, users
Giờ ta có thể xem nội dung các bảng ví dụ như bảng users:
Các cột trong bảng users “id=999 UNION SELECT 1,NULL,NULL,NULL,NULL,NULL,(SELECT GROUP_CONCAT(column_name) FROM information_schema.columns WHERE table_name = 'users'),NULL, NULL,NULL”:

![image](https://github.com/user-attachments/assets/428ee14c-0d57-4409-8be9-54f03978de84)

Xem nội dung users “id=999 UNION SELECT 1,NULL,NULL,NULL,NULL,(SELECT GROUP_CONCAT(name,':',password) FROM users),NULL,NULL,NULL,NULL”:

![image](https://github.com/user-attachments/assets/df7ef355-0faa-438a-a86d-0294efa95580)

⇒ Ta tìm được tài khoản:mật khẩu là admin:admin123
⇒ Cách khắc phục: Sử dụng các hàm có sẵn như findOrFail() thay vì viết câu lệnh sql hoặc cần valid dữ liệu cẩn trọng trước khi truyền vào.

### ***c. Sql Injection Inferential(Boolean Based)***
Giao diện của page nhìn qua gần giống với giao diện của page Sql Injection In-Band nhưng để ý có thêm chức năng like:

![image](https://github.com/user-attachments/assets/d153f0c0-81cb-47dc-b59e-058a2d1d1495)

Thực hiện like bài bất kỳ và quan sát BurpSuite:

![image](https://github.com/user-attachments/assets/050bdc46-ccb5-4958-add4-57e4c8f8a9c5)

Khi like method POST đã được gọi đến và response trả về một json:
{"success":true,"likes":124}
Quan sát code ta chỉ thấy được id truyền vào không được valid và response trả về chỉ có 2 trạng thái là true hoặc false:

![image](https://github.com/user-attachments/assets/857158d7-4edd-4734-b5b8-b513707b9bc2)

Như chúng ta đã biết ở ý b) trong database hiện tại có một bảng users có một record có name là admin giờ chúng ta sẽ khai thác theo cách boolean based để tìm ra mật khẩu:
Ta chèn id như sau “1 and 1=1” kết quả trả về là true và “1 and 1=2” thì kết quả là false:

![image](https://github.com/user-attachments/assets/ed96e479-7409-4bd2-968d-4e9b2692891f)

Ta lợi dụng việc này để tìm kiếm chiều dài và từng ký tự một của mật khẩu bằng cách tìm kiếm nhị phân:
Tìm kiếm chiều dài ta thực hiện tiêm câu lệnh sql sau “1 and (select length(password) from users name="admin")<16”:

![image](https://github.com/user-attachments/assets/03ffb059-702f-47b7-952c-a5cf97df6f2f)

Response trả về true khi ta thay đổi thành >= 8, sau một vài lần thử ta tìm được độ dài là 8: 

![image](https://github.com/user-attachments/assets/720ec250-09ce-409c-bdfb-3ff74ed68cc7)

Thực hiện rò tìm từng ký tự của mật khẩu ta có thể dùng Intruder của burpsuite:

![image](https://github.com/user-attachments/assets/46e4d499-e087-48e4-8912-0a9f24ecc39f)

Kết quả: 

![image](https://github.com/user-attachments/assets/34dd5bb0-fb42-4f7c-9f27-3cc1f60e4b95)

⇒ Mật khẩu tìm được là admin123


### ***d. Reflected XSS***
Nhìn qua giao diện:

![image](https://github.com/user-attachments/assets/eeec9500-d2d8-43c8-98f6-2f27c67d64c7)

Ta nhập một tên bất kỳ vào thì nó trả về một dòng chữ Hello + <Username>:

![image](https://github.com/user-attachments/assets/b308d116-e8a5-4667-b793-74f0694640eb)

Ta chèn một đoạn mã đơn giản <script>alert(“I’m hacker”)</script> và submit:

![image](https://github.com/user-attachments/assets/f72ccb19-861a-44f1-a3cd-4c13af1efbf5)

Như vậy một thông báo hiện nên ⇒ đây là ví dụ đơn giản điển hình cho lỗ hổng về Reflected XSS 


### ***e. Stored XSS***
Trong giao diện của trang chứa lỗ hổng Stored XSS ta sẽ thấy phần comment đây là nơi chứa lỗ hổng Stored XSS:

![image](https://github.com/user-attachments/assets/e2f5d1b1-1856-4ff7-a48b-bb657b865cc3)

Đọc code:

![image](https://github.com/user-attachments/assets/e050f653-ad8c-41ed-891b-bd5439236e30)

Comment không được valid mà cứ thế được lưu và cơ sở dữ liệu.
Ta thử chèn đoạn mã <script>alert(‘hacker’)</script> và submit:

![image](https://github.com/user-attachments/assets/46c2a72c-e8e8-4396-8e6d-546c61c990d1)

Thông báo như này hiện ra, nhìn có vẻ giống Reflected XSS nhưng đây là Stored XSS đoạn mã XSS được lưu vào cơ sở dữ liệu. Vì vậy các lần sau khi load trang đoạn thông báo kia đều sẽ xuất hiện.


## **2. File Upload**
Giao diện của trang:

![image](https://github.com/user-attachments/assets/651bc30d-aa52-4400-874e-7ba7c931e4ff)

Thử upload một file ảnh và quan sát burpsuite:

![image](https://github.com/user-attachments/assets/f3454ee0-538a-49bb-a706-62ac8f24ba5d)

![image](https://github.com/user-attachments/assets/aa59cfe6-da47-49f9-9e38-e9f898caa6bb)

Đọc code:

![image](https://github.com/user-attachments/assets/fb0da0e2-a729-47dc-be63-3a1218bcf447)

Ta hoàn toàn có thể bypass kiểm tra MIME type và bypass kiểm tra header file bằng cách chỉnh sửa thông tin từ trình duyệt gửi lên. Sử dụng tính năng Repeater trong burpsuite gửi file php lên và sửa phần Content-Type trong phần header request, chèn thêm “\xFF\xD8\xFF” để vượt qua kiểm tra:

![image](https://github.com/user-attachments/assets/80d254aa-9adf-485f-93e1-4c9b8a4a12a3)

Ở đây chúng ta lợi dụng file ảnh đã gửi lên trước đó, chỉ cần chỉnh tên file thành shell.php và chèn thêm đoạn mã php “<?php system($_GET['cmd']); ?>” vào cuối file ảnh mà thôi.
Kết quả file đã được upload thành công:

![image](https://github.com/user-attachments/assets/40f4d3e1-fa68-45b2-81ee-19241c630bfe)

Ta vào url và truyền tham số cmd để thực hiện lệnh ví dụ: “http://localhost:8000/uploads/1738812132shell.php?cmd=cat /etc/passwd”
Kết quả ta đọc được file /etc/passwd:

![image](https://github.com/user-attachments/assets/a0702c18-a398-443f-aec6-c00c8e24d053)

⇒ Cách khắc phục: Tắt thực thi file trong thư mục uploads bằng file .htaccess hoặc kiểm tra kỹ cả nội dung file

## **3. Server-side Request Forgery**
Giao diện trang:

![image](https://github.com/user-attachments/assets/c29fd568-9720-4e97-b93f-ff5953a51b88)

Thử một url bất kỳ trên mạng và submit:

![image](https://github.com/user-attachments/assets/a3729556-143f-43b5-b9d2-b0b19d9d9995)

Hình ảnh được tair về qua url và được hiển thị
Ta sẽ thử điền url là địa chỉ localhost xem như thế nào:

![image](https://github.com/user-attachments/assets/2bf1f25f-a8a4-44fb-a41a-52b102932a21)

Nó chặn cả 127.0.0.1 và localhost, ta cùng xem source code:

![image](https://github.com/user-attachments/assets/fccbbb76-b981-4a5e-8383-c87645895c5d)

Đoạn code tồn tại lỗ hổng bảo mật SSRF, khi lọc địa chỉ không cẩn thận. Ta có thể điền url sau "file:///etc/passwd” và submit:

![image](https://github.com/user-attachments/assets/9d6b63e2-f263-492b-b4fd-9292772c1025)

Sau khi submit ta không thấy kết quả gì được hiển thị:

![image](https://github.com/user-attachments/assets/e99f05a2-2132-41a5-bf7c-8a89dd701803)

Nhưng khi ta mở view-source của trang lên để ý đường dẫn trong thẻ img:

![image](https://github.com/user-attachments/assets/eaadf01f-a257-4500-8ebb-e94d392216d5)

Click và ta sẽ thấy nội dung file /etc/passwd được hiện ra:

![image](https://github.com/user-attachments/assets/f78a4c37-6e44-46f6-8b66-74e7a257262b)

⇒ Biện pháp khắc phục:
Chặn hoàn toàn IP nội bộ (192.168.x.x, 10.x.x.x, 127.0.0.1, ::1).
Kiểm tra loại file trước khi lưu (chỉ cho phép ảnh).
Chặn bypass bằng ký tự @ trong URL.
Dùng danh sách domain cho phép tải file(allow list)


## **4. Path Traversal**
Xem giao diện trang:

![image](https://github.com/user-attachments/assets/1359a3e7-c6b3-4ba9-ad4b-0a6a8948ae11)

Để ý đến đường dẫn url với tham số view=home.blade.php khi ta chuyển sang trang login và register thì tham số này cũng thay đổi theo là view=login.blade.php và view=register.blade.php
Cùng xem code:

![image](https://github.com/user-attachments/assets/67aa5903-a929-41c0-a74e-271c60985fea)

$view được truyền trực tiếp vào mà không được valid điều này dẫn đến lỗ hổng Path Traversal.
Bây giờ chúng ta thử truyền view=../../../../../../../../etc/passwd  xem có đọc được file passwd không:

![image](https://github.com/user-attachments/assets/b9a7822c-fcda-44bf-906e-3239afcc0d6e)

Không có gì ngạc nhiên khi đây chính là nội dung file passwd do tồn lỗ hổng Path Traversal, chúng ta có thể đọc các file trên máy mục tiêu.
Nếu trên trang có chỗ upload file thì chúng hãy thử upload file bình thường nhưng chứa code php và chèn đường dẫn đến file upload đó vào view để thực thi nó.
⇒ Khắc phục: Xóa các ký tự đặc biệt như ‘../’ lưu ý xóa đến khi không còn ‘../’ trong view phòng trường hợp untrusted data truyền vào là ‘....//’. Dùng whitelist để chỉ cho phép đọc các trang trong danh sách.
