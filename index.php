<?php
$counterFile = "counter.txt";

if (!file_exists($counterFile)) {
    file_put_contents($counterFile, 0);
}

$count = (int)file_get_contents($counterFile);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Klik</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('gambar/j.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 80px;
            font-family: Verdana, sans-serif;
            user-select: none;
            position: relative;
            overflow: hidden;
        }



        #counter {
            transition: transform 0.1s ease;
        }

        /* Tombol reset */
        #resetBtn {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            color: black;
            background: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            z-index: 100;
        }

        /* Gambar */
        .fly-image {
            position: absolute;
            left: -150px;
            width: 100px;
            height: auto;
            object-fit: contain;
            animation: fly 2.5s linear forwards;
        }


        @keyframes fly {
            0% {
                left: -150px;
            }

            100% {
                left: 110%;
            }
        }
    </style>
</head>

<body>

    <button id="resetBtn">Reset</button>
    <audio id="clickSound" src="gambar/Yodayo.mp3" preload="auto"></audio>
    <div id="counter"><?php echo $count; ?></div>

    <script>
        const counter = document.getElementById("counter");
        const resetBtn = document.getElementById("resetBtn");

        function addCount() {

            document.getElementById("clickSound").cloneNode(true).play();

            counter.style.transform = "scale(1.2)";
            setTimeout(() => counter.style.transform = "scale(1)", 100);

            fetch("klik.php")
                .then(res => res.text())
                .then(newCount => {
                    counter.textContent = newCount;
                });

            spawnFlyingImage();
        }

        function spawnFlyingImage() {
            const img = document.createElement("img");

            img.src = "gambar/ayame.png";
            img.className = "fly-image";

            img.style.top = (Math.random() * 70 + 10) + "%";

            document.body.appendChild(img);

            setTimeout(() => {
                img.remove();
            }, 2600);
        }


        document.addEventListener("click", function(e) {
            if (e.target !== resetBtn) addCount();
        });

        document.addEventListener("touchstart", function(e) {
            if (e.target !== resetBtn) addCount();
        });

        resetBtn.addEventListener("click", function() {
            fetch("reset.php")
                .then(res => res.text())
                .then(newCount => {
                    counter.textContent = newCount;
                });
        });
    </script>

</body>

</html>
