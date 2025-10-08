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
      padding: 15px;
      overflow-x: hidden;
      font-size: 15px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      max-width: 1100px;
      margin: 0 auto;
    }

    .form-section, .summary-section {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      flex: 1;
      min-width: 280px;
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 15px;
      padding-bottom: 6px;
      border-bottom: 2px solid #3498db;
      font-size: 18px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #2c3e50;
      font-size: 14px;
    }

    select, input[type="number"], input[type="date"], input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
      transition: border 0.3s;
    }

    select:focus, input[type="number"]:focus, input[type="date"]:focus, input[type="text"]:focus {
      border-color: #3498db;
      outline: none;
    }

    button {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #2980b9;
    }

    .action-buttons {
      display: flex;
      justify-content: flex-end;
      margin-top: 8px;
    }

    .update-btn {
      background-color: #2ecc71;
      padding: 6px 12px;
      font-size: 13px;
      border-radius: 4px;
    }

    .update-btn:hover {
      background-color: #27ae60;
    }

    .delete-btn {
      background-color: #e74c3c;
      padding: 6px 12px;
      font-size: 13px;
      border-radius: 4px;
      margin-right: 8px;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    /* Print Button */
    .print-btn {
      background-color: #e67e22;
      margin-bottom: 15px;
      margin-right: 10px;
    }

    .print-btn:hover {
      background-color: #d35400;
    }

    /* Blue Summary Box */
    .summary-section {
      background-color: #2c3e50;
      color: white;
      max-height: 85vh;
      overflow-y: auto;
      position: sticky;
      top: 10px;
    }

    .summary-section h2 {
      color: white;
      border-bottom: 2px solid #3498db;
      position: sticky;
      top: 0;
      background: #2c3e50;
      padding: 8px 0;
      z-index: 10;
    }

    .summary-machine {
      margin-bottom: 15px;
      padding: 12px;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 8px;
      background-color: rgba(255,255,255,0.05);
      font-size: 14px;
    }

    .summary-machine h3 {
      color: #3498db;
      margin-bottom: 8px;
      font-size: 15px;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .summary-item:last-child {
      border-bottom: none;
      font-weight: bold;
      color: #3498db;
    }

    .difference {
      font-weight: bold;
      margin-top: 5px;
      padding: 5px;
      border-radius: 4px;
      text-align: center;
    }

    .positive {
      background-color: rgba(46, 204, 113, 0.2);
      color: #2ecc71;
    }

    .negative {
      background-color: rgba(231, 76, 60, 0.2);
      color: #e74c3c;
    }

    .neutral {
      background-color: rgba(52, 152, 219, 0.2);
      color: #3498db;
    }

    /* Daily Summary Section */
    .daily-summary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .daily-summary h3 {
      color: white;
      margin-bottom: 15px;
      font-size: 18px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .daily-totals {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .total-item {
      background: rgba(255, 255, 255, 0.1);
      padding: 12px;
      border-radius: 8px;
      backdrop-filter: blur(10px);
    }

    .total-label {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .total-value {
      font-size: 18px;
      font-weight: bold;
      color: white;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    /* Print Styles */
    @media print {
      body * {
        visibility: hidden;
      }
      #printSummary, #printSummary * {
        visibility: visible;
      }
      #printSummary {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
        color: black;
        padding: 20px;
      }
      .no-print {
        display: none !important;
      }
      .print-break {
        page-break-after: always;
      }
    }

    .print-header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
    }

    .print-machine {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .print-machine h4 {
      color: #2c3e50;
      margin-bottom: 8px;
      border-bottom: 1px solid #eee;
      padding-bottom: 5px;
    }

    .print-item {
      display: flex;
      justify-content: space-between;
      padding: 3px 0;
    }

    .print-totals {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-top: 20px;
    }

    /* Setup Page Styles */
    .setup-container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .setup-container h1 {
      color: #2c3e50;
      margin-bottom: 20px;
      text-align: center;
      font-size: 24px;
    }

    .setup-container p {
      margin-bottom: 20px;
      text-align: center;
      color: #7f8c8d;
    }

    .machine-setup {
      margin-bottom: 20px;
      padding: 15px;
      border: 1px solid #eee;
      border-radius: 8px;
    }

    .machine-setup h3 {
      color: #3498db;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .setup-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .skip-btn {
      background-color: #95a5a6;
    }

    .skip-btn:hover {
      background-color: #7f8c8d;
    }

    /* View Initial Capital Button */
    .view-initial-btn {
      background-color: #9b59b6;
      margin-bottom: 15px;
    }

    .view-initial-btn:hover {
      background-color: #8e44ad;
    }

    /* Cash Balancing Button */
    .balance-btn {
      background-color: #e74c3c;
      margin-bottom: 15px;
      margin-right: 10px;
    }

    .balance-btn:hover {
      background-color: #c0392b;
    }

    /* Date Navigation */
    .date-navigation {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      padding: 10px;
      background-color: rgba(255,255,255,0.1);
      border-radius: 5px;
    }

    .date-nav-btn {
      background-color: #3498db;
      padding: 8px 12px;
      font-size: 12px;
    }

    .current-date {
      font-weight: bold;
      color: #3498db;
    }

    /* Initial Capital Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 100;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      max-height: 80vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 25px;
      border-bottom: 2px solid #3498db;
      background: white;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .modal-header h2 {
      margin: 0;
      border: none;
      padding: 0;
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #7f8c8d;
      padding: 0;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .close-btn:hover {
      color: #e74c3c;
      background-color: #f5f5f5;
      border-radius: 50%;
    }

    .modal-body {
      padding: 0 25px 25px;
      overflow-y: auto;
      flex: 1;
    }

    .initial-machine {
      margin-bottom: 15px;
      padding: 12px;
      border: 1px solid #eee;
      border-radius: 8px;
      position: relative;
    }

    .initial-machine h3 {
      color: #3498db;
      margin-bottom: 8px;
      font-size: 15px;
    }

    .initial-item {
      display: flex;
      justify-content: space-between;
      padding: 4px 0;
      border-bottom: 1px solid #eee;
    }

    .initial-item:last-child {
      border-bottom: none;
      font-weight: bold;
      color: #3498db;
    }

    .add-machine-form {
      margin-top: 20px;
      padding: 15px;
      border: 1px dashed #3498db;
      border-radius: 8px;
      background-color: rgba(52, 152, 219, 0.05);
    }

    .add-machine-form h3 {
      color: #3498db;
      margin-bottom: 10px;
    }

    .add-machine-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 10px;
    }

    .cancel-btn {
      background-color: #95a5a6;
    }

    .cancel-btn:hover {
      background-color: #7f8c8d;
    }

    .edit-initial-btn {
      background-color: #f39c12;
      padding: 4px 8px;
      font-size: 12px;
      border-radius: 4px;
      margin-right: 5px;
    }

    .edit-initial-btn:hover {
      background-color: #e67e22;
    }

    .delete-initial-btn {
      background-color: #e74c3c;
      padding: 4px 8px;
      font-size: 12px;
      border-radius: 4px;
    }

    .delete-initial-btn:hover {
      background-color: #c0392b;
    }

    .initial-actions {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    /* Comma formatting for numbers */
    .formatted-number {
      font-family: 'Courier New', monospace;
      letter-spacing: 0.5px;
    }

    /* Cash Balancing Styles */
    .balance-section {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
      flex: 1;
      min-width: 280px;
    }

    .balance-section h2 {
      color: #2c3e50;
      margin-bottom: 15px;
      padding-bottom: 6px;
      border-bottom: 2px solid #3498db;
      font-size: 18px;
    }

    .balance-instructions {
      background-color: #fff3cd;
      border: 1px solid #ffeaa7;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 15px;
      font-size: 14px;
    }

    .balance-instructions h4 {
      color: #856404;
      margin-bottom: 8px;
    }

    .balance-instructions ul {
      margin-left: 20px;
      color: #856404;
    }

    .balance-instructions li {
      margin-bottom: 5px;
    }

    .balance-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 14px;
    }

    .balance-table th {
      background-color: #3498db;
      color: white;
      padding: 12px;
      text-align: left;
      font-weight: 600;
    }

    .balance-table td {
      padding: 12px;
      border-bottom: 1px solid #eee;
    }

    .balance-table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    .balance-table tr:hover {
      background-color: #e3f2fd;
    }

    .from-machine {
      color: #e74c3c;
      font-weight: bold;
    }

    .to-machine {
      color: #2ecc71;
      font-weight: bold;
    }

    .balance-amount {
      font-weight: bold;
      color: #3498db;
    }

    .balance-summary {
      margin-top: 20px;
      padding: 15px;
      background-color: #f8f9fa;
      border-radius: 8px;
      border-left: 4px solid #3498db;
    }

    .balance-summary h4 {
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .balance-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .apply-balance-btn {
      background-color: #2ecc71;
    }

    .apply-balance-btn:hover {
      background-color: #27ae60;
    }

    .clear-balance-btn {
      background-color: #95a5a6;
    }

    .clear-balance-btn:hover {
      background-color: #7f8c8d;
    }

    .quick-transfer {
      background-color: #d1ecf1;
      border: 1px solid #bee5eb;
      border-radius: 5px;
      padding: 10px;
      margin-top: 10px;
      font-size: 13px;
    }

    .quick-transfer h5 {
      color: #0c5460;
      margin-bottom: 5px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .summary-section {
        max-height: 60vh;
      }
      .initial-actions {
        position: static;
        margin-top: 10px;
        display: flex;
        justify-content: flex-end;
      }
      .date-navigation {
        flex-direction: column;
        gap: 10px;
      }
      .modal-content {
        width: 95%;
        max-height: 90vh;
      }
      .daily-totals {
        grid-template-columns: 1fr;
      }
      .balance-actions {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <!-- Initial Setup Page -->
  <div id="setupPage" class="setup-container" style="display: none;">
    <h1>Welcome to Cash Flow Tracker</h1>
    <p>Let's set up your initial cash balances for each machine. This will help you track changes over time.</p>
    
    <div id="setupMachines">
      <!-- Machine setup fields will be generated here -->
    </div>
    
    <div class="setup-buttons">
      <button id="skipSetup" class="skip-btn">Skip Setup</button>
      <button id="saveSetup">Save Initial Balances</button>
    </div>
  </div>

  <!-- Main Application -->
  <div id="mainApp" class="container" style="display: none;">
    <div class="form-section">
      <h2>Enter Daily Balances</h2>
      <form id="balanceForm">
        <div class="form-group">
          <label>Select Machine:</label>
          <select id="machineSelect" required>
            <option value="">-- Choose Machine --</option>
            <!-- Options will be populated dynamically -->
          </select>
        </div>
        
        <div class="form-group">
          <label>Cash in Machine (TZS):</label>
          <input type="text" id="cashInMachine" required placeholder="Enter amount in machine (e.g., 1,000,000)">
        </div>
        
        <div class="form-group">
          <label>Cash at Shop (TZS):</label>
          <input type="text" id="cashAtShop" required placeholder="Enter amount at shop (e.g., 500,000)">
        </div>
        
        <div class="form-group">
          <label>Cash at Home (TZS):</label>
          <input type="text" id="cashAtHome" required placeholder="Enter amount at home (e.g., 200,000)">
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
      <div class="no-print">
        <button id="balanceCashBtn" class="balance-btn">💰 Balance Cash</button>
        <button id="printSummaryBtn" class="print-btn">🖨️ Print Full Summary</button>
        <button id="viewInitialBtn" class="view-initial-btn">📊 View/Manage Initial Capital</button>
      </div>
      
      <!-- Date Navigation -->
      <div class="date-navigation no-print">
        <button id="prevDate" class="date-nav-btn">◀ Previous Day</button>
        <span id="currentDateDisplay" class="current-date">Today</span>
        <button id="nextDate" class="date-nav-btn">Next Day ▶</button>
      </div>
      
      <!-- Daily Summary -->
      <div id="dailySummary" class="daily-summary" style="display: none;">
        <h3>Daily Summary - <span id="summaryDate"></span></h3>
        <div class="daily-totals">
          <div class="total-item">
            <div class="total-label">Total Machines</div>
            <div id="totalMachines" class="total-value">0</div>
          </div>
          <div class="total-item">
            <div class="total-label">Total Cash</div>
            <div id="totalCash" class="total-value">0 TZS</div>
          </div>
          <div class="total-item">
            <div class="total-label">Total in Machines</div>
            <div id="totalInMachines" class="total-value">0 TZS</div>
          </div>
          <div class="total-item">
            <div class="total-label">Total at Shop</div>
            <div id="totalAtShop" class="total-value">0 TZS</div>
          </div>
          <div class="total-item">
            <div class="total-label">Total at Home</div>
            <div id="totalAtHome" class="total-value">0 TZS</div>
          </div>
        </div>
      </div>
      
      <div id="summaryContent"></div>
    </div>

    <!-- Cash Balancing Section -->
    <div id="balanceSection" class="balance-section" style="display: none;">
      <h2>💰 Cash Balancing</h2>
      <div class="balance-instructions">
        <h4>📋 How to Balance Your Cash:</h4>
        <ul>
          <li><strong>Red Amounts:</strong> Machines that have EXTRA cash (need to GIVE cash)</li>
          <li><strong>Green Amounts:</strong> Machines that NEED cash (need to RECEIVE cash)</li>
          <li><strong>Simple Rule:</strong> Move cash from RED machines to GREEN machines</li>
          <li><strong>Goal:</strong> Make all daily changes zero by transferring cash between machines</li>
        </ul>
      </div>
      <div id="balanceContent"></div>
    </div>
  </div>

  <!-- Initial Capital Modal -->
  <div id="initialCapitalModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Initial Capital Management</h2>
        <button class="close-btn" title="Close">✕</button>
      </div>
      <div class="modal-body">
        <div id="initialCapitalContent">
          <!-- Initial capital data will be displayed here -->
        </div>
        
        <!-- Add New Machine Form -->
        <div class="add-machine-form">
          <h3>Add New Machine</h3>
          <div class="form-group">
            <label>Machine Name:</label>
            <input type="text" id="newMachineName" placeholder="Enter machine name">
          </div>
          <div class="form-group">
            <label>Initial Cash in Machine (TZS):</label>
            <input type="text" id="newMachineCash" placeholder="Enter initial amount in machine (e.g., 1,000,000)">
          </div>
          <div class="form-group">
            <label>Initial Cash at Shop (TZS):</label>
            <input type="text" id="newMachineShop" placeholder="Enter initial amount at shop (e.g., 500,000)">
          </div>
          <div class="form-group">
            <label>Initial Cash at Home (TZS):</label>
            <input type="text" id="newMachineHome" placeholder="Enter initial amount at home (e.g., 200,000)">
          </div>
          <div class="add-machine-buttons">
            <button id="cancelAddMachine" class="cancel-btn">Cancel</button>
            <button id="saveNewMachine">Add Machine</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Print Summary (Hidden until print) -->
  <div id="printSummary" style="display: none;"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const setupPage = document.getElementById("setupPage");
      const mainApp = document.getElementById("mainApp");
      const setupMachines = document.getElementById("setupMachines");
      const skipSetupBtn = document.getElementById("skipSetup");
      const saveSetupBtn = document.getElementById("saveSetup");
      const viewInitialBtn = document.getElementById("viewInitialBtn");
      const balanceCashBtn = document.getElementById("balanceCashBtn");
      const printSummaryBtn = document.getElementById("printSummaryBtn");
      const initialCapitalModal = document.getElementById("initialCapitalModal");
      const initialCapitalContent = document.getElementById("initialCapitalContent");
      const closeModalBtn = document.querySelector(".close-btn");
      const saveNewMachineBtn = document.getElementById("saveNewMachine");
      const cancelAddMachineBtn = document.getElementById("cancelAddMachine");
      const machineSelect = document.getElementById("machineSelect");
      const prevDateBtn = document.getElementById("prevDate");
      const nextDateBtn = document.getElementById("nextDate");
      const currentDateDisplay = document.getElementById("currentDateDisplay");
      const dailySummary = document.getElementById("dailySummary");
      const summaryDate = document.getElementById("summaryDate");
      const totalMachines = document.getElementById("totalMachines");
      const totalCash = document.getElementById("totalCash");
      const totalInMachines = document.getElementById("totalInMachines");
      const totalAtShop = document.getElementById("totalAtShop");
      const totalAtHome = document.getElementById("totalAtHome");
      const printSummary = document.getElementById("printSummary");
      const balanceSection = document.getElementById("balanceSection");
      const balanceContent = document.getElementById("balanceContent");
      
      const balanceForm = document.getElementById("balanceForm");
      const summaryContent = document.getElementById("summaryContent");
      const balanceDate = document.getElementById("balanceDate");

      const today = new Date().toISOString().split("T")[0];
      balanceDate.value = today;

      let balances = {};
      let initialBalances = {};
      let currentDisplayDate = today;

      // Default machines
      const defaultMachines = [
        "NMB", "CRDB", "NBC", "MKOMBOZI", "EQUITY", 
        "TCB", "UCHUMI", "M-PESA", "TIGO", "AIRTEL", "HALOTEL"
      ];

      // Format number with commas
      function formatNumber(num) {
        if (isNaN(num)) return "0";
        return Number(num).toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }

      // Parse formatted number (remove commas)
      function parseFormattedNumber(str) {
        if (!str) return 0;
        const cleaned = str.replace(/[^\d.]/g, '');
        return parseFloat(cleaned) || 0;
      }

      // Format input value as user types
      function formatInput(event) {
        const input = event.target;
        const cursorPosition = input.selectionStart;
        
        let value = input.value.replace(/[^\d.]/g, '');
        
        const decimalParts = value.split('.');
        if (decimalParts.length > 2) {
          value = decimalParts[0] + '.' + decimalParts.slice(1).join('');
        }
        
        const parts = value.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        const newValue = parts.join('.');
        input.value = newValue;
        
        const newCursorPosition = cursorPosition + (newValue.length - input.value.length);
        input.setSelectionRange(newCursorPosition, newCursorPosition);
      }

      // NEW FUNCTION: Calculate cash balancing between machines
      function calculateCashBalancing(currentBalances, prevBalances, initialBalances) {
        const machineChanges = [];
        
        // Calculate daily changes for each machine
        for (const [machine, currentData] of Object.entries(currentBalances)) {
          let dailyChange = 0;
          
          if (prevBalances && prevBalances[machine]) {
            dailyChange = currentData.total - prevBalances[machine].total;
          } else if (initialBalances[machine]) {
            dailyChange = currentData.total - initialBalances[machine].total;
          }
          
          machineChanges.push({
            machine,
            dailyChange,
            currentTotal: currentData.total
          });
        }
        
        // Sort machines by daily change (most negative to most positive)
        machineChanges.sort((a, b) => a.dailyChange - b.dailyChange);
        
        const transfers = [];
        let i = 0;
        let j = machineChanges.length - 1;
        
        // Match machines that need cash with machines that have extra cash
        while (i < j) {
          const needer = machineChanges[i];  // Machine that needs cash (negative change)
          const giver = machineChanges[j];   // Machine that has extra cash (positive change)
          
          // If both are balanced, move on
          if (needer.dailyChange >= 0 && giver.dailyChange <= 0) break;
          
          const needAmount = Math.abs(needer.dailyChange);
          const giveAmount = Math.abs(giver.dailyChange);
          const transferAmount = Math.min(needAmount, giveAmount);
          
          if (transferAmount > 0.01) { // Only create transfers for significant amounts
            transfers.push({
              fromMachine: giver.machine,
              toMachine: needer.machine,
              amount: transferAmount,
              reason: `Balance daily changes: ${giver.machine} (+${formatNumber(giver.dailyChange)}) → ${needer.machine} (${formatNumber(needer.dailyChange)})`
            });
            
            // Update the changes after transfer
            needer.dailyChange += transferAmount;
            giver.dailyChange -= transferAmount;
            
            // If needer is now balanced, move to next needer
            if (Math.abs(needer.dailyChange) < 0.01) {
              i++;
            }
            
            // If giver is now balanced, move to next giver
            if (Math.abs(giver.dailyChange) < 0.01) {
              j--;
            }
          } else {
            // If no significant transfer can be made, move pointers
            if (needAmount <= giveAmount) {
              i++;
            } else {
              j--;
            }
          }
        }
        
        // Calculate summary
        const totalNeeded = machineChanges
          .filter(m => m.dailyChange < -0.01)
          .reduce((sum, m) => sum + Math.abs(m.dailyChange), 0);
          
        const totalAvailable = machineChanges
          .filter(m => m.dailyChange > 0.01)
          .reduce((sum, m) => sum + m.dailyChange, 0);
        
        return {
          transfers,
          machineChanges,
          totalNeeded,
          totalAvailable,
          netDifference: totalAvailable - totalNeeded,
          canBalance: Math.abs(totalAvailable - totalNeeded) < 0.01
        };
      }

      // NEW FUNCTION: Display cash balancing interface
      function displayCashBalancing() {
        const currentBalances = balances[currentDisplayDate];
        if (!currentBalances || Object.keys(currentBalances).length === 0) {
          balanceSection.style.display = 'none';
          return;
        }

        // Get previous day's date
        const prevDate = new Date(currentDisplayDate);
        prevDate.setDate(prevDate.getDate() - 1);
        const prevDateStr = prevDate.toISOString().split("T")[0];
        const prevBalances = balances[prevDateStr];

        // Calculate balancing
        const balanceData = calculateCashBalancing(currentBalances, prevBalances, initialBalances);
        
        if (balanceData.transfers.length === 0 && Math.abs(balanceData.netDifference) < 0.01) {
          balanceSection.style.display = 'none';
          return;
        }

        balanceSection.style.display = 'block';
        
        let balanceHTML = '';
        
        // Show current daily changes
        balanceHTML += `
          <div class="balance-summary">
            <h4>📊 Current Daily Changes</h4>
        `;
        
        balanceData.machineChanges.forEach(machine => {
          const changeClass = machine.dailyChange > 0 ? 'positive' : 
                            (machine.dailyChange < 0 ? 'negative' : 'neutral');
          const changeSign = machine.dailyChange > 0 ? '+' : '';
          
          balanceHTML += `
            <div class="summary-item">
              <span>${machine.machine}:</span>
              <span class="${changeClass} formatted-number">${changeSign}${formatNumber(machine.dailyChange)} TZS</span>
            </div>
          `;
        });
        
        balanceHTML += `</div>`;
        
        // Show transfers if any
        if (balanceData.transfers.length > 0) {
          balanceHTML += `
            <h3 style="margin: 20px 0 10px 0; color: #2c3e50;">🔄 Required Cash Transfers</h3>
            <table class="balance-table">
              <thead>
                <tr>
                  <th>From Machine</th>
                  <th>To Machine</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
          `;
          
          balanceData.transfers.forEach(transfer => {
            balanceHTML += `
              <tr>
                <td class="from-machine">${transfer.fromMachine}</td>
                <td class="to-machine">${transfer.toMachine}</td>
                <td class="balance-amount formatted-number">${formatNumber(transfer.amount)} TZS</td>
                <td>
                  <div>Move cash from ${transfer.fromMachine} to ${transfer.toMachine}</div>
                  <div class="quick-transfer">
                    <h5>💡 Quick Action:</h5>
                    Take ${formatNumber(transfer.amount)} TZS from <strong>${transfer.fromMachine}</strong> 
                    and give it to <strong>${transfer.toMachine}</strong>
                  </div>
                </td>
              </tr>
            `;
          });
          
          balanceHTML += `
              </tbody>
            </table>
          `;
        }
        
        // Show summary
        balanceHTML += `
          <div class="balance-summary">
            <h4>🎯 Balancing Summary</h4>
            <div class="summary-item">
              <span>Total Cash Needed:</span>
              <span class="negative formatted-number">${formatNumber(balanceData.totalNeeded)} TZS</span>
            </div>
            <div class="summary-item">
              <span>Total Cash Available:</span>
              <span class="positive formatted-number">${formatNumber(balanceData.totalAvailable)} TZS</span>
            </div>
            <div class="summary-item">
              <span>Net Difference:</span>
              <span class="${balanceData.netDifference === 0 ? 'neutral' : (balanceData.netDifference > 0 ? 'positive' : 'negative')} formatted-number">
                ${formatNumber(balanceData.netDifference)} TZS
              </span>
            </div>
            <div class="summary-item">
              <span>Status:</span>
              <span><strong>${balanceData.canBalance ? '✅ Perfect Balance Possible' : '⚠️ Partial Balance Only'}</strong></span>
            </div>
          </div>
        `;
        
        // Add action buttons
        balanceHTML += `
          <div class="balance-actions">
            <button class="apply-balance-btn" onclick="applyAllTransfers()">✅ Apply All Transfers</button>
            <button class="clear-balance-btn" onclick="clearBalanceDisplay()">❌ Clear Display</button>
          </div>
        `;
        
        // Add simple instructions for common scenarios
        if (balanceData.transfers.length > 0) {
          balanceHTML += `
            <div class="balance-instructions" style="background-color: #d1ecf1; border-color: #bee5eb; margin-top: 15px;">
              <h4>🚀 Quick Start Guide:</h4>
              <ul>
                <li><strong>Start with the largest transfer first</strong></li>
                <li>Physically move cash between machines as shown above</li>
                <li>After each transfer, the daily changes will get closer to zero</li>
                <li>Use "Apply All Transfers" to automatically update balances</li>
              </ul>
            </div>
          `;
        }

        balanceContent.innerHTML = balanceHTML;
      }

      // NEW FUNCTION: Apply all transfers automatically
      window.applyAllTransfers = function() {
        const currentBalances = balances[currentDisplayDate];
        const prevDate = new Date(currentDisplayDate);
        prevDate.setDate(prevDate.getDate() - 1);
        const prevDateStr = prevDate.toISOString().split("T")[0];
        const prevBalances = balances[prevDateStr];
        
        const balanceData = calculateCashBalancing(currentBalances, prevBalances, initialBalances);
        
        let updatedCount = 0;
        
        balanceData.transfers.forEach(transfer => {
          const fromMachine = currentBalances[transfer.fromMachine];
          const toMachine = currentBalances[transfer.toMachine];
          
          if (fromMachine && toMachine) {
            // Move cash from one machine to another (adjust cash at shop)
            fromMachine.cashShop -= transfer.amount;
            fromMachine.total -= transfer.amount;
            
            toMachine.cashShop += transfer.amount;
            toMachine.total += transfer.amount;
            
            updatedCount++;
          }
        });
        
        if (updatedCount > 0) {
          // Save updated balances
          localStorage.setItem('dailyBalances', JSON.stringify(balances));
          displaySummary();
          displayCashBalancing();
          alert(`✅ Successfully applied ${updatedCount} cash transfers! Daily changes have been balanced.`);
        } else {
          alert('⚠️ No transfers were applied. Please check if you have any balancing recommendations.');
        }
      };

      // NEW FUNCTION: Clear balance display
      window.clearBalanceDisplay = function() {
        balanceSection.style.display = 'none';
      };

      // Generate print summary
      function generatePrintSummary() {
        const currentBalances = balances[currentDisplayDate];
        if (!currentBalances || Object.keys(currentBalances).length === 0) {
          alert("No balance data available for the selected date.");
          return;
        }

        // Calculate totals
        let totalCashSum = 0;
        let totalInMachinesSum = 0;
        let totalAtShopSum = 0;
        let totalAtHomeSum = 0;
        const machineCount = Object.keys(currentBalances).length;

        for (const [machine, data] of Object.entries(currentBalances)) {
          totalCashSum += data.total;
          totalInMachinesSum += data.cashMachine;
          totalAtShopSum += data.cashShop;
          totalAtHomeSum += data.cashHome;
        }

        // Get previous day's date and balances
        const prevDate = new Date(currentDisplayDate);
        prevDate.setDate(prevDate.getDate() - 1);
        const prevDateStr = prevDate.toISOString().split("T")[0];
        const prevBalances = balances[prevDateStr];

        // Build print content
        let printHTML = `
          <div class="print-header">
            <h1>Daily Balance Summary Report</h1>
            <h2>${formatDisplayDate(currentDisplayDate)}</h2>
            <p>Generated on ${new Date().toLocaleDateString()}</p>
          </div>

          <div class="print-totals">
            <h3>Daily Totals</h3>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 15px;">
              <div><strong>Total Machines:</strong> ${machineCount}</div>
              <div><strong>Total Cash:</strong> ${formatNumber(totalCashSum)} TZS</div>
              <div><strong>Cash in Machines:</strong> ${formatNumber(totalInMachinesSum)} TZS</div>
              <div><strong>Cash at Shop:</strong> ${formatNumber(totalAtShopSum)} TZS</div>
              <div><strong>Cash at Home:</strong> ${formatNumber(totalAtHomeSum)} TZS</div>
            </div>
          </div>

          <div style="margin-top: 30px;">
            <h3>Machine Details</h3>
        `;

        // Add each machine's details
        for (const [machine, data] of Object.entries(currentBalances)) {
          // Calculate difference from previous day
          let difference = 0;
          let differenceClass = "neutral";
          let comparisonText = "No previous day data";
          
          if (prevBalances && prevBalances[machine]) {
            difference = data.total - prevBalances[machine].total;
            differenceClass = difference > 0 ? "positive" : (difference < 0 ? "negative" : "neutral");
            comparisonText = `Compared to ${prevDateStr}`;
          } else if (initialBalances[machine]) {
            difference = data.total - initialBalances[machine].total;
            differenceClass = difference > 0 ? "positive" : (difference < 0 ? "negative" : "neutral");
            comparisonText = "Compared to initial capital";
          }

          printHTML += `
            <div class="print-machine">
              <h4>${machine}</h4>
              <div class="print-item"><span>Cash in Machine:</span><span>${formatNumber(data.cashMachine)} TZS</span></div>
              <div class="print-item"><span>Cash at Shop:</span><span>${formatNumber(data.cashShop)} TZS</span></div>
              <div class="print-item"><span>Cash at Home:</span><span>${formatNumber(data.cashHome)} TZS</span></div>
              <div class="print-item" style="font-weight: bold; border-top: 1px solid #eee; margin-top: 5px; padding-top: 5px;">
                <span>Total:</span><span>${formatNumber(data.total)} TZS</span>
              </div>
              <div class="print-item"><span>${comparisonText}:</span><span style="color: ${difference > 0 ? 'green' : difference < 0 ? 'red' : 'blue'}">${difference > 0 ? '+' : ''}${formatNumber(difference)} TZS</span></div>
            </div>
          `;
        }

        printHTML += `</div>`;
        
        // Set print content and trigger print
        printSummary.innerHTML = printHTML;
        window.print();
      }

      // Calculate and display daily summary
      function displayDailySummary(currentBalances) {
        if (!currentBalances || Object.keys(currentBalances).length === 0) {
          dailySummary.style.display = 'none';
          return;
        }

        dailySummary.style.display = 'block';
        
        // Calculate totals
        let totalCashSum = 0;
        let totalInMachinesSum = 0;
        let totalAtShopSum = 0;
        let totalAtHomeSum = 0;
        const machineCount = Object.keys(currentBalances).length;

        for (const [machine, data] of Object.entries(currentBalances)) {
          totalCashSum += data.total;
          totalInMachinesSum += data.cashMachine;
          totalAtShopSum += data.cashShop;
          totalAtHomeSum += data.cashHome;
        }

        // Update summary elements
        summaryDate.textContent = formatDisplayDate(currentDisplayDate);
        totalMachines.textContent = machineCount;
        totalCash.textContent = formatNumber(totalCashSum) + ' TZS';
        totalInMachines.textContent = formatNumber(totalInMachinesSum) + ' TZS';
        totalAtShop.textContent = formatNumber(totalAtShopSum) + ' TZS';
        totalAtHome.textContent = formatNumber(totalAtHomeSum) + ' TZS';
      }

      // Format date for display
      function formatDisplayDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
      }

      // Set up keyboard navigation for form inputs
      function setupKeyboardNavigation() {
        const inputs = [
          document.getElementById('cashInMachine'),
          document.getElementById('cashAtShop'), 
          document.getElementById('cashAtHome'),
          document.getElementById('balanceDate')
        ];

        inputs.forEach((input, index) => {
          input.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
              e.preventDefault();
              if (index < inputs.length - 1) {
                inputs[index + 1].focus();
              }
            } else if (e.key === 'ArrowUp') {
              e.preventDefault();
              if (index > 0) {
                inputs[index - 1].focus();
              } else {
                document.getElementById('machineSelect').focus();
              }
            }
          });
        });

        // Also set up for initial capital modal inputs
        const modalInputs = [
          document.getElementById('newMachineName'),
          document.getElementById('newMachineCash'),
          document.getElementById('newMachineShop'),
          document.getElementById('newMachineHome')
        ];

        modalInputs.forEach((input, index) => {
          if (input) {
            input.addEventListener('keydown', function(e) {
              if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (index < modalInputs.length - 1) {
                  modalInputs[index + 1].focus();
                }
              } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (index > 0) {
                  modalInputs[index - 1].focus();
                }
              }
            });
          }
        });
      }

      // Check if initial balances are already set
      function checkInitialSetup() {
        const savedInitialBalances = localStorage.getItem('initialBalances');
        if (savedInitialBalances) {
          initialBalances = JSON.parse(savedInitialBalances);
          mainApp.style.display = 'flex';
          setupPage.style.display = 'none';
          updateMachineSelect();
          setupKeyboardNavigation();
        } else {
          // Show setup page
          mainApp.style.display = 'none';
          setupPage.style.display = 'block';
          generateSetupFields();
        }
        
        // Load saved daily balances
        const savedBalances = localStorage.getItem('dailyBalances');
        if (savedBalances) {
          balances = JSON.parse(savedBalances);
          displaySummary();
        }
        
        // Update date display
        updateDateDisplay();
      }

      // Update machine select dropdown
      function updateMachineSelect() {
        machineSelect.innerHTML = '<option value="">-- Choose Machine --</option>';
        
        // Get all machines from initialBalances
        const machines = Object.keys(initialBalances);
        
        machines.forEach(machine => {
          const option = document.createElement('option');
          option.value = machine;
          option.textContent = machine;
          machineSelect.appendChild(option);
        });
      }

      // Generate setup fields for all machines
      function generateSetupFields() {
        setupMachines.innerHTML = '';
        
        defaultMachines.forEach(machine => {
          const machineDiv = document.createElement('div');
          machineDiv.classList.add('machine-setup');
          machineDiv.innerHTML = `
            <h3>${machine}</h3>
            <div class="form-group">
              <label>Initial Cash in Machine (TZS):</label>
              <input type="text" id="initial-${machine}-machine" placeholder="Enter initial amount in machine (e.g., 1,000,000)" oninput="formatInput(event)">
            </div>
            <div class="form-group">
              <label>Initial Cash at Shop (TZS):</label>
              <input type="text" id="initial-${machine}-shop" placeholder="Enter initial amount at shop (e.g., 500,000)" oninput="formatInput(event)">
            </div>
            <div class="form-group">
              <label>Initial Cash at Home (TZS):</label>
              <input type="text" id="initial-${machine}-home" placeholder="Enter initial amount at home (e.g., 200,000)" oninput="formatInput(event)">
            </div>
          `;
          setupMachines.appendChild(machineDiv);
        });
      }

      // Save initial balances
      saveSetupBtn.addEventListener('click', function() {
        defaultMachines.forEach(machine => {
          const cashMachine = parseFormattedNumber(document.getElementById(`initial-${machine}-machine`).value) || 0;
          const cashShop = parseFormattedNumber(document.getElementById(`initial-${machine}-shop`).value) || 0;
          const cashHome = parseFormattedNumber(document.getElementById(`initial-${machine}-home`).value) || 0;
          const total = cashMachine + cashShop + cashHome;
          
          if (total > 0) {
            initialBalances[machine] = { cashMachine, cashShop, cashHome, total };
          }
        });
        
        localStorage.setItem('initialBalances', JSON.stringify(initialBalances));
        updateMachineSelect();
        mainApp.style.display = 'flex';
        setupPage.style.display = 'none';
        setupKeyboardNavigation();
      });

      // Skip setup
      skipSetupBtn.addEventListener('click', function() {
        mainApp.style.display = 'flex';
        setupPage.style.display = 'none';
        setupKeyboardNavigation();
      });

      // View initial capital
      viewInitialBtn.addEventListener('click', function() {
        displayInitialCapital();
        initialCapitalModal.style.display = 'flex';
        // Focus on first input in modal
        setTimeout(() => {
          document.getElementById('newMachineName').focus();
        }, 100);
      });

      // Balance cash button
      balanceCashBtn.addEventListener('click', function() {
        displayCashBalancing();
      });

      // Print summary
      printSummaryBtn.addEventListener('click', generatePrintSummary);

      // Close modal
      closeModalBtn.addEventListener('click', function() {
        initialCapitalModal.style.display = 'none';
      });

      // Cancel adding new machine
      cancelAddMachineBtn.addEventListener('click', function() {
        document.getElementById('newMachineName').value = '';
        document.getElementById('newMachineCash').value = '';
        document.getElementById('newMachineShop').value = '';
        document.getElementById('newMachineHome').value = '';
      });

      // Save new machine
      saveNewMachineBtn.addEventListener('click', function() {
        const machineName = document.getElementById('newMachineName').value.trim();
        const cashMachine = parseFormattedNumber(document.getElementById('newMachineCash').value) || 0;
        const cashShop = parseFormattedNumber(document.getElementById('newMachineShop').value) || 0;
        const cashHome = parseFormattedNumber(document.getElementById('newMachineHome').value) || 0;
        
        if (!machineName) {
          alert('Please enter a machine name.');
          return;
        }
        
        if (initialBalances[machineName]) {
          alert('Machine already exists.');
          return;
        }
        
        const total = cashMachine + cashShop + cashHome;
        initialBalances[machineName] = { cashMachine, cashShop, cashHome, total };
        
        localStorage.setItem('initialBalances', JSON.stringify(initialBalances));
        updateMachineSelect();
        displayInitialCapital();
        
        // Clear form
        document.getElementById('newMachineName').value = '';
        document.getElementById('newMachineCash').value = '';
        document.getElementById('newMachineShop').value = '';
        document.getElementById('newMachineHome').value = '';
      });

      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target === initialCapitalModal) {
          initialCapitalModal.style.display = 'none';
        }
      });

      // Close modal with Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && initialCapitalModal.style.display === 'flex') {
          initialCapitalModal.style.display = 'none';
        }
      });

      // Date navigation
      prevDateBtn.addEventListener('click', function() {
        navigateDate(-1);
      });

      nextDateBtn.addEventListener('click', function() {
        navigateDate(1);
      });

      // Navigate between dates
      function navigateDate(direction) {
        const date = new Date(currentDisplayDate);
        date.setDate(date.getDate() + direction);
        currentDisplayDate = date.toISOString().split("T")[0];
        updateDateDisplay();
        displaySummary();
      }

      // Update date display
      function updateDateDisplay() {
        const date = new Date(currentDisplayDate);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        currentDateDisplay.textContent = date.toLocaleDateString('en-US', options);
        
        // Disable next button if it's today or future
        nextDateBtn.disabled = currentDisplayDate >= today;
      }

      // Display initial capital in modal
      function displayInitialCapital() {
        initialCapitalContent.innerHTML = '';
        
        if (Object.keys(initialBalances).length === 0) {
          initialCapitalContent.innerHTML = '<p>No initial capital data available.</p>';
          return;
        }
        
        for (const [machine, data] of Object.entries(initialBalances)) {
          const div = document.createElement("div");
          div.classList.add("initial-machine");
          div.innerHTML = `
            <h3>${machine}</h3>
            <div class="initial-item"><span>Cash in Machine:</span><span class="formatted-number">${formatNumber(data.cashMachine)} TZS</span></div>
            <div class="initial-item"><span>Cash at Shop:</span><span class="formatted-number">${formatNumber(data.cashShop)} TZS</span></div>
            <div class="initial-item"><span>Cash at Home:</span><span class="formatted-number">${formatNumber(data.cashHome)} TZS</span></div>
            <div class="initial-item"><span>Total:</span><span class="formatted-number">${formatNumber(data.total)} TZS</span></div>
            <div class="initial-actions">
              <button class="edit-initial-btn" onclick="editInitialBalance('${machine}')">✏️ Edit</button>
              <button class="delete-initial-btn" onclick="deleteInitialBalance('${machine}')">🗑️ Delete</button>
            </div>
          `;
          initialCapitalContent.appendChild(div);
        }
        
        // Calculate and display grand total
        const grandTotal = Object.values(initialBalances).reduce((sum, data) => sum + data.total, 0);
        const totalDiv = document.createElement("div");
        totalDiv.classList.add("initial-machine");
        totalDiv.innerHTML = `
          <h3>Grand Total</h3>
          <div class="initial-item"><span>Total Initial Capital:</span><span class="formatted-number">${formatNumber(grandTotal)} TZS</span></div>
        `;
        initialCapitalContent.appendChild(totalDiv);
      }

      // Edit initial balance
      window.editInitialBalance = function(machine) {
        const data = initialBalances[machine];
        
        // Create edit form
        const editForm = document.createElement('div');
        editForm.classList.add('add-machine-form');
        editForm.innerHTML = `
          <h3>Edit ${machine}</h3>
          <div class="form-group">
            <label>Cash in Machine (TZS):</label>
            <input type="text" id="edit-${machine}-machine" value="${formatNumber(data.cashMachine)}" oninput="formatInput(event)">
          </div>
          <div class="form-group">
            <label>Cash at Shop (TZS):</label>
            <input type="text" id="edit-${machine}-shop" value="${formatNumber(data.cashShop)}" oninput="formatInput(event)">
          </div>
          <div class="form-group">
            <label>Cash at Home (TZS):</label>
            <input type="text" id="edit-${machine}-home" value="${formatNumber(data.cashHome)}" oninput="formatInput(event)">
          </div>
          <div class="add-machine-buttons">
            <button class="cancel-btn" onclick="cancelEdit('${machine}')">Cancel</button>
            <button onclick="saveEditedBalance('${machine}')">Save Changes</button>
          </div>
        `;
        
        // Replace the machine display with edit form
        const machineElements = document.querySelectorAll('.initial-machine h3');
        for (let element of machineElements) {
          if (element.textContent === machine) {
            element.parentNode.innerHTML = editForm.innerHTML;
            break;
          }
        }
      };

      // Cancel edit
      window.cancelEdit = function(machine) {
        displayInitialCapital();
      };

      // Save edited balance
      window.saveEditedBalance = function(machine) {
        const cashMachine = parseFormattedNumber(document.getElementById(`edit-${machine}-machine`).value) || 0;
        const cashShop = parseFormattedNumber(document.getElementById(`edit-${machine}-shop`).value) || 0;
        const cashHome = parseFormattedNumber(document.getElementById(`edit-${machine}-home`).value) || 0;
        const total = cashMachine + cashShop + cashHome;
        
        initialBalances[machine] = { cashMachine, cashShop, cashHome, total };
        localStorage.setItem('initialBalances', JSON.stringify(initialBalances));
        updateMachineSelect();
        displayInitialCapital();
        displaySummary(); // Refresh the main summary to show updated differences
      };

      // Delete initial balance
      window.deleteInitialBalance = function(machine) {
        if (confirm(`Are you sure you want to delete the initial balance for ${machine}?`)) {
          delete initialBalances[machine];
          localStorage.setItem('initialBalances', JSON.stringify(initialBalances));
          updateMachineSelect();
          displayInitialCapital();
          displaySummary(); // Refresh the main summary
        }
      };

      // Save daily balance
      balanceForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const machine = document.getElementById("machineSelect").value;
        const cashMachine = parseFormattedNumber(document.getElementById("cashInMachine").value) || 0;
        const cashShop = parseFormattedNumber(document.getElementById("cashAtShop").value) || 0;
        const cashHome = parseFormattedNumber(document.getElementById("cashAtHome").value) || 0;
        const date = document.getElementById("balanceDate").value;
        const total = cashMachine + cashShop + cashHome;

        if (!machine) {
          alert("Please select a machine.");
          return;
        }

        // Store with date
        if (!balances[date]) {
          balances[date] = {};
        }
        
        balances[date][machine] = { cashMachine, cashShop, cashHome, total };
        
        // Save to localStorage
        localStorage.setItem('dailyBalances', JSON.stringify(balances));
        
        // Clean up old data (keep only last 2 months)
        cleanOldData();
        
        displaySummary();
        balanceForm.reset();
        balanceDate.value = today;
        currentDisplayDate = today;
        updateDateDisplay();
      });

      // Clean up data older than 2 months
      function cleanOldData() {
        const twoMonthsAgo = new Date();
        twoMonthsAgo.setMonth(twoMonthsAgo.getMonth() - 2);
        
        Object.keys(balances).forEach(date => {
          if (new Date(date) < twoMonthsAgo) {
            delete balances[date];
          }
        });
        
        localStorage.setItem('dailyBalances', JSON.stringify(balances));
      }

      // Display summary for the current display date
      function displaySummary() {
        summaryContent.innerHTML = "";
        
        // Get the current display date's balances
        const currentBalances = balances[currentDisplayDate];
        
        if (!currentBalances || Object.keys(currentBalances).length === 0) {
          summaryContent.innerHTML = `<p>No balance data available for ${currentDisplayDate}</p>`;
          dailySummary.style.display = 'none';
          balanceSection.style.display = 'none';
          return;
        }
        
        // Display daily summary
        displayDailySummary(currentBalances);
        
        // Get previous day's date
        const prevDate = new Date(currentDisplayDate);
        prevDate.setDate(prevDate.getDate() - 1);
        const prevDateStr = prevDate.toISOString().split("T")[0];
        const prevBalances = balances[prevDateStr];
        
        for (const [machine, data] of Object.entries(currentBalances)) {
          const div = document.createElement("div");
          div.classList.add("summary-machine");
          
          // Calculate difference from previous day
          let difference = 0;
          let differenceClass = "neutral";
          let comparisonText = "No previous day data";
          
          if (prevBalances && prevBalances[machine]) {
            difference = data.total - prevBalances[machine].total;
            differenceClass = difference > 0 ? "positive" : (difference < 0 ? "negative" : "neutral");
            comparisonText = `Compared to ${prevDateStr}`;
          } else if (initialBalances[machine]) {
            // If no previous day data, compare with initial capital
            difference = data.total - initialBalances[machine].total;
            differenceClass = difference > 0 ? "positive" : (difference < 0 ? "negative" : "neutral");
            comparisonText = "Compared to initial capital";
          }
          
          div.innerHTML = `
            <h3>${machine} - ${currentDisplayDate}</h3>
            <div class="summary-item"><span>Cash in Machine:</span><span class="formatted-number">${formatNumber(data.cashMachine)} TZS</span></div>
            <div class="summary-item"><span>Cash at Shop:</span><span class="formatted-number">${formatNumber(data.cashShop)} TZS</span></div>
            <div class="summary-item"><span>Cash at Home:</span><span class="formatted-number">${formatNumber(data.cashHome)} TZS</span></div>
            <div class="summary-item"><span>Total:</span><span class="formatted-number">${formatNumber(data.total)} TZS</span></div>
            <div class="summary-item"><span>${comparisonText}:</span><span class="formatted-number">${difference > 0 ? '+' : ''}${formatNumber(difference)} TZS</span></div>
            <div class="difference ${differenceClass}">
              Daily Change: ${difference > 0 ? '+' : ''}${formatNumber(difference)} TZS
            </div>
            <div class="action-buttons">
              <button class="delete-btn" onclick="deleteBalance('${currentDisplayDate}', '${machine}')">🗑️ Delete</button>
              <button class="update-btn" onclick="updateBalance('${currentDisplayDate}', '${machine}')">✏️ Update</button>
            </div>
          `;
          summaryContent.appendChild(div);
        }
      }

      // Update balance
      window.updateBalance = function(date, machine) {
        const data = balances[date][machine];
        document.getElementById("machineSelect").value = machine;
        document.getElementById("cashInMachine").value = formatNumber(data.cashMachine);
        document.getElementById("cashAtShop").value = formatNumber(data.cashShop);
        document.getElementById("cashAtHome").value = formatNumber(data.cashHome);
        document.getElementById("balanceDate").value = date;
      };

      // Delete balance
      window.deleteBalance = function(date, machine) {
        if (confirm(`Are you sure you want to delete the balance for ${machine} on ${date}?`)) {
          delete balances[date][machine];
          
          // If no more balances for this date, remove the date
          if (Object.keys(balances[date]).length === 0) {
            delete balances[date];
          }
          
          localStorage.setItem('dailyBalances', JSON.stringify(balances));
          displaySummary();
        }
      };

      // Initialize the app
      checkInitialSetup();
      
      // Make formatInput function available globally
      window.formatInput = formatInput;
      
      // Set up input formatting for cash fields
      document.getElementById('cashInMachine').addEventListener('input', formatInput);
      document.getElementById('cashAtShop').addEventListener('input', formatInput);
      document.getElementById('cashAtHome').addEventListener('input', formatInput);
      document.getElementById('newMachineCash').addEventListener('input', formatInput);
      document.getElementById('newMachineShop').addEventListener('input', formatInput);
      document.getElementById('newMachineHome').addEventListener('input', formatInput);
    });
  </script>
</body>
</html>