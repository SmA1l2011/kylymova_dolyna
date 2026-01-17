    import './bootstrap'

    import Alpine from 'alpinejs'

    window.Alpine = Alpine

    Alpine.start()

    window.onload = function () {
        let rating = document.querySelector("#rating"),
            stars = document.querySelectorAll("#star"),
            starCount,
            offset = 0
        if (rating) {
            stars.forEach(star => {
                star.classList.add("active")
                star.style.left = offset+"px"
                offset += 27
            })
            rating.oninput = function () {
                starCount = rating.value
                stars.forEach(star => {
                    if (starCount > 0) {
                        star.classList.add("active")
                    } else {
                        star.classList.remove("active")
                    }
                    starCount--
                })
            }
        }

        let searchFilterBlock = document.querySelector(".search-filter__block"),
            filtersButton = document.querySelector(".filters-button"),
            filterSortBlock = document.querySelector(".filter-sort__block"),
            clearFilterBlock = document.querySelector(".clear-filter__block")

        if (searchFilterBlock) {
            searchFilterBlock.onclick = function () {
                filterSortBlock.classList.toggle("active")
                filtersButton.classList.toggle("filters-button__active")
                clearFilterBlock.classList.toggle("clear-filter__block-active")
            }
        }

        let category = document.querySelector(".filter-block__category"),
            select = document.querySelector(".filter-block__subcategory"),
            options = document.querySelectorAll(".filter-block__option"),
            categoryIdsJson = document.querySelector(".categoryIdsJson").value,
            categoryIds = JSON.parse(categoryIdsJson),
            isOptionTrue

        if (category) {
            if (category.value == "all") {
                select.disabled = true
            }
            category.oninput = function () {
                if (category.value != "all") {
                    select.disabled = false
                    options.forEach(option => {
                        isOptionTrue = false
                        categoryIds[category.value].forEach(subcategory => {
                            if (isOptionTrue) {
                                return;
                            } else {
                                if (option.value == subcategory["id"]) {
                                    option.style.display = "inline-block"
                                    isOptionTrue = true
                                } else {
                                    option.style.display = "none";
                                }
                            }
                        })
                    })
                } else {
                    select.disabled = true   
                    options.forEach(option => {
                        option.style.display = "inline-block"
                    })
                }
            }
        }

        // let orderNumber = document.querySelector(".orderNumber"),
        //     orderForm = document.querySelector(".orderForm")

        // if (orderNumber) {
        //     category.oninput = function () {
        //         orderForm.submit()
        //     }
        // }
    }