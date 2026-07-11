 window.onscroll = () => {
            if (window.scrollY < 70) {
                document.querySelector("nav").style.borderBottom = "1px solid transparent"
            }
            if (window.scrollY > 70) {
                document.querySelector("nav").style.borderBottom = "1px solid rgb(239, 239, 239)"
            }
        }