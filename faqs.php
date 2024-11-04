<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retro Clouds PH - FAQs</title>
    <link rel="stylesheet" href="./styles/output.css">
    <link rel="stylesheet" href="./styles/faqs.css">
    <link rel="shortcut icon" href="./assets/mist-logo.png" type="image/x-icon">
    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background-color: #1A1D3B;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(#1A1D3B, #FF1695, #1A1D3B);
            border-radius: 50px;
        }
        .faqs_container {
    transition: grid-template-rows 0.3s ease-out;
}

.faqs_container.active {
    grid-template-rows: 1fr !important;
}

.accordion_icons {
    transition: transform 0.3s ease;
}

.faqs_title.active .accordion_icons {
    transform: rotate(180deg);
}
    </style>
</head>

<body class="bg-[#1A1D3B]" id="scroll-top">

    <!-- Navigation -->
    <?php
    require("conf/config.php");
    require("navbar.php");

    $sql = "SELECT * FROM faqs";
    $result1 = $conn->query($sql);

    if (!$result1) {
        echo "Error: " . $conn->error;
    }
    ?>

    <!-- <div class="bg-[#1A1D3B] w-full max-w-full h-[30vh] pt-16 px-4 flex items-center justify-center flex-wrap mobilemd:px-6 iphone:pt-20 sm:h-[35vh] sm:px-8 md:px-10 lg:px-12 xl:px-14 laptopxxl:px-40 laptopxxl:h-[40vh] ">
        <div class="w-full flex flex-col gap-4 items-center justify-center sm:gap-2">
            <h2 class="retro-clouds-h2 text-[#ff1695] uppercase text-base font-medium w-full iphone:text-xl lg:text-2xl">Asked Questions</h2>
            <h1 class="retro_clouds_h2 text-white uppercase text-2xl font-bold w-full iphone:text-2xl sm:text-4xl lg:text-5xl laptopxxl:text-6xl">FAQs</h1>
        </div>
    </div> -->
    <!-- <h2 class="retro-clouds-h2 text-[#ff1695] uppercase text-base font-medium w-full iphone:text-xl lg:text-2xl">Asked Questions</h2> -->
    <h1 class="retro_clouds_h2 text-white uppercase text-2xl font-bold w-full iphone:text-2xl sm:text-4xl lg:text-5xl laptopxxl:text-6xl">FAQs</h1>
    
    <div class="retro_clouds_bg_gradient w-full max-w-full h-auto py-8 px-4 flex items-start justify-start flex-wrap mobilemd:px-6 sm:px-8 md:px-10 lg:px-12 xl:px-14 laptopxxl:px-40">
        <div class="w-full max-w-full flex flex-col gap-8 laptopxxl:gap-10">
            <?php
            while ($faqs = $result1->fetch_assoc()) {
            ?>
                <div class="accordions bg-gradient-to-r from-[#33FCFF] to-[#1F9799] border border-[#1A1D3B] rounded-lg">
                    <div class="faqs_title flex items-center justify-between p-2 px-8 w-full gap-4 iphone:h-[70px] iphone:max-h-[70px] iphone:p-4 sm:h-[80px] sm:max-h-[80px] sm:p-6 lg:h-[90px] lg:max-h-[90px] laptopxxl:h-[100px] laptopxxl:max-h-[100px] laptopxxl:py-8" onclick="toggleAnswer(this)">
                        <i class="fa-solid fa-circle-question text-[#FF1695] text-4xl xl:text-6xl"></i>
                        <span class="retro_clouds_h2 text-sm uppercase font-bold text-[#FF1695] mobilemd:text-base iphone:text-lg sm:text-xl xl:text-2xl xl:tracking-wider laptopxxl:text-3xl"><?php echo $faqs["question"]; ?></span>
                        <i class="fa-sharp fa-solid fa-chevron-down text-base accordion_icons font-bold text-[#FF1695] laptopxxl:text-lg"></i>
                    </div>

                    <div class="faqs_container grid grid-rows-[0] overflow-hidden rounded-b-lg bg-[#1A1D3B]" style="display: none;">
                        <div class="min-h-0 p-2 lg:p-4 xl:p-6">
                            <p class="retro_clouds_p text-white text-sm font-normal mobilelg:text-base xl:tracking-wide laptopxxl:text-2xl"> <?php echo $faqs["answer"]; ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>



    <?php
    require("conf/foot.php");
    ?>

    <!-- Font Awesome -->
    <script>
function toggleAnswer(element) {
    const answerContainer = element.nextElementSibling;
    const content = answerContainer.querySelector('div');
    
    // Toggle active classes
    element.classList.toggle('active');
    answerContainer.classList.toggle('active');
    
    // Handle display and animation
    if (!answerContainer.classList.contains('active')) {
        // Closing
        answerContainer.style.gridTemplateRows = '0fr';
        // Wait for animation to complete before hiding
        setTimeout(() => {
            answerContainer.style.display = 'none';
        }, 300); // Match transition duration
    } else {
        // Opening
        answerContainer.style.display = 'grid';
        // Trigger reflow
        answerContainer.offsetHeight;
        answerContainer.style.gridTemplateRows = '1fr';
    }
}

// Initialize all accordions to be closed
document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.faqs_container');
    containers.forEach(container => {
        container.style.gridTemplateRows = '0fr';
    });
});
</script>
</body>
</html>
