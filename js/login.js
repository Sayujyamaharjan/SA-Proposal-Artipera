window.addEventListener("DOMContentLoaded", () => {
    const be_a_worker = document.querySelector("#be_a_worker");
    const be_a_customer = document.querySelector("#be_a_customer");
    const SliderElement = document.querySelector("#login_image");
    const driverLoginContainer = document.querySelector("#driverLogin");
    const customeLoginContainer = document.querySelector("#customeLogin");
    const customerLoginBtn = document.querySelector("#customerLoginBtn");
    const customerNextBtn = document.querySelector("#customerNextBtn");

    const workerProcess = [
        "worker_login_part_1", "worker_login_part_2"
    ]

    let current = -1;
    let last = 0;
    function makeVisible(c) {


        last = current;
        current = (current + 1) % workerProcess.length;
        if (document.querySelector(`#${workerProcess[workerProcess.length - 1]}`).classList.contains("hidden")) {

            document.querySelector(`#${workerProcess[last]}`)?.classList.add("hidden");
            document.querySelector(`#${workerProcess[current]}`)?.classList.remove("hidden");
        } else {
            SliderElement.classList.remove("move_right")
            SliderElement.classList.add("move_left")
            setTimeout(() => {

                document.querySelector(`#${workerProcess[0]}`)?.classList.remove("hidden");
                document.querySelector(`#${workerProcess[last]}`)?.classList.add("hidden");
            }, 1000);

        }
    }
    customerNextBtn?.addEventListener("click", (e) => {
        e.preventDefault()

        makeVisible(current)
    })

    customerLoginBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        SliderElement.classList.remove("move_right")
        SliderElement.classList.add("move_left")
    })

    be_a_worker?.addEventListener("click", (e) => {
        e.preventDefault()
        SliderElement.classList.remove("move_left")
        SliderElement.classList.add("move_right")
        customeLoginContainer.classList.add("hidden")
        driverLoginContainer.classList.remove("hidden")
        current = -1;
        last = 0;
        makeVisible(current)
    });
    be_a_customer?.addEventListener("click", (e) => {
        e.preventDefault()
        SliderElement.classList.remove("move_left")
        SliderElement.classList.add("move_right")
        customeLoginContainer.classList.remove("hidden")
        driverLoginContainer.classList.add("hidden")
    });
});