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

## **2. File Upload**



## **3. Server-side Request Forgery**



## **4. Path Traversal**
