# about project

## what

![plan from book](./note/bookplan.png)

จากรูปคือ plan diagram จากหนังสือเรื่อง universal data model resource book vol1  ที่ รองศาสตราจารย์ ดร.วรา วราวิทย์ ให้ผมไปศึกษา เเละนำมาสร้างเป็น database จริงๆ ด้วย postgresql แล้ว ***ทำ crud service ให้กับ ทุก entity***

## how

### tech stack

- [docker](https://www.docker.com/)
ใช้เป็น env ในการ run ทั้ง project เเละทำให้ project เป็น cloud based native application

- [postgresql](https://www.postgresql.org/)
ใช้ในการสร้าง database

- [postgresadmin](https://www.pgadmin.org/)
ใช้สำหรับสร้าง database structure เเละ execute query ใน postgresql

- [php](https://www.w3schools.com/php/)
เป็นภาษาที่ใช้ในการทำ backend

- [pdo](https://www.php.net/manual/en/book.pdo.php)
เป็น engine สำคัญในการต่อ backend กับ database

- [react](https://reactjs.org/)
เป็น framework ที่ใช้ในการทำ frontend ติดต่อกับ backend เเละผลักภาระในการประมวลผล gui ให้ฝั่ง client

- [vite](https://vite.dev/guide/)
เป็น tool ที่มาคู่กับ react ทำให้ง่ายกับตัวผม ในการเขียน frontend เพราะมันมี hot module replacement ให้

- [swc](https://www.dhiwise.com/post/maximize-performance-how-swc-enhances-vite-and-react)
เป็น option ให้เลือกตั้งเเต่ตอน npm create vite ผมไม่เเน่ว่าคืออะไร เเต่ community เขาบอกว่าทำให้ vite เร็วขึ้น เพราะ compiler เป็นภาษา rust

