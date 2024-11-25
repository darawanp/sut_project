document.addEventListener("DOMContentLoaded", () => {
    const seats = document.querySelectorAll(".seat:not(.occupied)");
    const reserveButton = document.getElementById("reserveButton");
    let selectedSeats = [];

    // คลิกเลือก/ยกเลิกที่นั่ง
    seats.forEach(seat => {
        seat.addEventListener("click", () => {
            if (!seat.classList.contains("occupied")) {
                seat.classList.toggle("selected");
                const seatNumber = seat.getAttribute("data-seat");
                if (seat.classList.contains("selected")) {
                    selectedSeats.push(seatNumber);
                } else {
                    selectedSeats = selectedSeats.filter(s => s !== seatNumber);
                }
            }
        });
    });

    // ส่งข้อมูลการจอง
    reserveButton.addEventListener("click", () => {
        if (selectedSeats.length > 0) {
            fetch("reserve.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ seats: selectedSeats })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("จองสำเร็จ!");
                        location.reload();
                    } else {
                        alert("เกิดข้อผิดพลาดในการจอง");
                    }
                });
        } else {
            alert("กรุณาเลือกที่นั่ง");
        }
    });
});
