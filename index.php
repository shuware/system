<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Balance Tracker</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .form-section, .summary-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            flex: 1;
            min-width: 300px;
        }
        
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        select, input[type="number"], input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        select:focus, input[type="number"]:focus, input[type="date"]:focus {
            border-color: #3498db;
            outline: none;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .nmb-input-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .nmb-input-container input {
            flex: 1;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .action-buttons button {
            padding: 8px 12px;
            font-size: 14px;
        }
        
        .delete-btn {
            background-color: #e74c3c;
        }
        
        .delete-btn:hover {
            background-color: #c0392b;
        }
        
        .update-btn {
            background-color: #2ecc71;
        }
        
        .update-btn:hover {
            background-color: #27ae60;
        }
        
        .summary-section {
            background-color: #2c3e50;
            color: white;
        }
        
        .summary-section h2 {
            color: white;
            border-bottom: 2px solid #3498db;
        }
        
        .summary-machine {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            background-color: rgba(255,255,255,0.05);
        }
        
        .summary-machine h3 {
            color: #3498db;
            margin-bottom: 10px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            color: #3498db;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h2>Enter Daily Balances</h2>
            <form id="balanceForm">
                <div class="form-group">
                    <label>Select Machine:</label>
                    <select id="machineSelect" required>
                        <option value="">-- Choose Machine --</option>
                        <option value="NMB">NMB</option>
                        <option value="CRDB">CRDB</option>
                        <option value="NBC">NBC</option>
                        <option value="MKOMBOZI">MKOMBOZI</option>
                        <option value="EQUITY">EQUITY</option>
                        <option value="TCB">TCB</option>
                        <option value="UCHUMI">UCHUMI</option>
                        <option value="M-PESA">M-PESA</option>
                        <option value="TIGO">TIGO</option>
                        <option value="AIRTEL">AIRTEL</option>
                        <option value="HALOTEL">HALOTEL</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Cash in Machine (TZS):</label>
                    <input type="number" step="0.01" id="cashInMachine" required placeholder="Enter amount in machine">
                </div>
                
                <div class="form-group">
                    <label>Cash at Shop (TZS):</label>
                    <input type="number" step="0.01" id="cashAtShop" required placeholder="Enter amount at shop">
                </div>
                
                <div class="form-group">
                    <label>Cash at Home (TZS):</label>
                    <input type="number" step="0.01" id="cashAtHome" required placeholder="Enter amount at home">
                </div>
                
                <div class="form-group">
                    <label>Date:</label>
                    <input type="date" id="balanceDate" value="">
                </div>
                
                <button type="submit">💾 Save Balance</button>
            </form>
        </div>
        
        <div class="summary-section">
            <h2>Balance Summary</h2>
            <div id="summaryContent"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const balanceForm = document.getElementById("balanceForm");
            const summaryContent = document.getElementById("summaryContent");
            const balanceDate = document.getElementById("balanceDate");

            // Set current date
            const today = new Date().toISOString().split("T")[0];
            balanceDate.value = today;

            // Store machine data
            let balances = {};

            balanceForm.addEventListener("submit", function(e) {
                e.preventDefault();

                const machine = document.getElementById("machineSelect").value;
                const cashMachine = parseFloat(document.getElementById("cashInMachine").value) || 0;
                const cashShop = parseFloat(document.getElementById("cashAtShop").value) || 0;
                const cashHome = parseFloat(document.getElementById("cashAtHome").value) || 0;

                const total = cashMachine + cashShop + cashHome;

                if (!machine) {
                    alert("Please select a machine.");
                    return;
                }

                // Save data
                balances[machine] = {
                    cashMachine,
                    cashShop,
                    cashHome,
                    total
                };

                displaySummary();
                balanceForm.reset();
                balanceDate.value = today;
            });

            function displaySummary() {
                summaryContent.innerHTML = "";

                for (const [machine, data] of Object.entries(balances)) {
                    const div = document.createElement("div");
                    div.classList.add("summary-machine");
                    div.innerHTML = `
                        <h3>${machine}</h3>
                        <div class="summary-item"><span>Cash in Machine:</span><span>${data.cashMachine.toFixed(2)} TZS</span></div>
                        <div class="summary-item"><span>Cash at Shop:</span><span>${data.cashShop.toFixed(2)} TZS</span></div>
                        <div class="summary-item"><span>Cash at Home:</span><span>${data.cashHome.toFixed(2)} TZS</span></div>
                        <div class="summary-item"><span>Total:</span><span>${data.total.toFixed(2)} TZS</span></div>
                    `;
                    summaryContent.appendChild(div);
                }
            }
        });
    </script>
</body>
</html>
