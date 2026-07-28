<footer style="background: #2c3e50; color: white; padding: 30px 0; text-align: center; margin-top: 50px; font-family: Arial, sans-serif;">
    <div style="width: 80%; margin: auto; border-top: 1px solid #555; padding-top: 20px;">
        
        <h3 style="color: #f1c40f; margin-bottom: 10px;">Project Credits</h3>
        <p style="font-size: 16px; margin: 5px 0;">
            This project is created by <b>Karan Dhaodiyal</b>, an <b>MCA Student</b>.
        </p>
        
        <p style="font-size: 14px; color: #bdc3c7; max-width: 600px; margin: 15px auto; line-height: 1.6;">
            The purpose of this <b>CampusConnect: Lost & Found Portal</b> is to help students reconnect with their lost belongings quickly and safely within the campus environment using a digital, real-time database system.
        </p>

        <div style="margin: 25px 0;">
            <button onclick="togglePayment()" style="background:#f1c40f; color:#2c3e50; font-weight:bold; border:none; padding:10px 20px; cursor:pointer; border-radius:5px; font-size: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                ☕ Buy Me a Coffee
            </button>

            <div id="paymentDetails" style="display: none; margin-top: 15px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px; border: 1px dashed #f1c40f;">
                <p style="margin: 5px 0;"><b>UPI ID:</b> <span style="color: #27ae60;">Karandhaodiyal@upi</span></p> 
                <p style="font-size: 12px; margin-bottom: 10px;">Scan to support Karan's Project:</p>
                
                <img src="assets/myqr.png" alt="Payment QR" style="width: 130px; height: 130px; border: 4px solid white; border-radius: 5px;">
                
                <p style="font-size: 11px; margin-top: 10px; font-style: italic; color: #bdc3c7;">
                    "Thank you for your kindness! ❤️"
                </p>
            </div>
        </div>

        <hr style="width: 50px; border: 1px solid #f1c40f; margin: 20px auto;">
        <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">
            &copy; <?php echo date("Y"); ?> CampusConnect Portal. All Rights Reserved.
        </p>

    </div>
</footer>

<script>
function togglePayment() {
    var x = document.getElementById("paymentDetails");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
