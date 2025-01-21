<?php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitty Dance Equipment Store - FAQ</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #F3A71B; margin: 0; padding: 0; color: #000;">

    <div class="container" style="max-width: 800px; margin: 30px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div class="faq-header" style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 24px; margin: 0;">FAQ</h1>
        </div>

        <?php 
        $faqs = [
            "Apa Itu Kitty Dance Equipment Store" => "Kitty Dance Equipment Store adalah toko online yang menyediakan alat-alat tari berkualitas.",
            "Bagaimana cara melakukan pemesanan di website ini?" => "Anda dapat melakukan pemesanan dengan memilih produk, menambahkannya ke keranjang, dan menyelesaikan proses pembayaran di halaman checkout.",
            "Apa saja alat-alat tari yang tersedia di Kitty Dance Equipment Store?" => "Kitty Dance Equipment Store menyediakan berbagai alat tari seperti sepatu tari, kostum, aksesori, dan perlengkapan lainnya.",
            "Metode pembayaran apa saja yang diterima?" => "Kami menerima pembayaran melalui transfer bank, kartu kredit, dan e-wallet seperti OVO dan GoPay.",
            "Berapa lama waktu pengiriman barang?" => "Waktu pengiriman tergantung lokasi Anda. Biasanya membutuhkan waktu 3-7 hari kerja.",
            "Apakah saya bisa mengembalikan atau menukar barang?" => "Ya, Anda dapat mengembalikan atau menukar barang sesuai dengan kebijakan pengembalian kami yang tercantum di website.",
            "Bagaimana cara menghubungi layanan pelanggan?" => "Anda dapat menghubungi layanan pelanggan melalui email, nomor telepon, atau fitur live chat yang tersedia di website kami."
        ];

        foreach ($faqs as $question => $answer) { ?>
            <div class="faq-item" style="margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; overflow: hidden;">
                <div class="faq-question" style="background-color: #FFCC33; padding: 15px; cursor: pointer; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
                    <?= $question ?> <span>+</span>
                </div>
                <div class="faq-answer" style="display: none; padding: 15px; background-color: #fff;">
                    <p style="margin: 0;"> <?= $answer ?> </p>
                </div>
            </div>
        <?php } ?>
    </div>

    <script>
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isVisible = answer.style.display === 'block';

                document.querySelectorAll('.faq-answer').forEach(ans => ans.style.display = 'none');

                answer.style.display = isVisible ? 'none' : 'block';
                question.querySelector('span').textContent = isVisible ? '+' : '-';
            });
        });
    </script>
</body>
</html>
?>
