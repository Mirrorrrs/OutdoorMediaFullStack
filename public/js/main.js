let bookmarkInfoButton = document.querySelector("#bookmarkInfoButton")
let bookmarkCalendarButton = document.querySelector("#bookmarkCalendarButton")
let bookmarkInfo = document.querySelector(".bookmarkInfo")
let bookmarkCalendar = document.querySelector(".bookmarkCalendar")
let bookBillboard = document.querySelector("#bookBillboard")
let billboardModal = document.querySelector("#billboardModal")
let billboardModalWindow = document.querySelector(".billboardModalWindow")
let excelInput = document.querySelector("#loadExcel")
let fileSpan = document.querySelector("#fileName")
let billboardMounting = document.querySelector("#billboardMounting")
let billboardTax = document.querySelector("#billboardTax")
let billboardPrinting = document.querySelector("#billboardPrinting")
let billboardSize = document.querySelector("#billboardSize")
let billboardSpotlight = document.querySelector("#billboardSpotlight")
let billboardMaterial = document.querySelector("#billboardMaterial")
let tableElements = document.querySelectorAll(".tableElement")

if(excelInput){
    excelInput.onchange = (ev)=>{
        fileSpan.innerHTML = "Выбран файл: "+ev.target.files[0].name
        fileSpan.classList.remove("hidden")
    }
}

function swapClasses(el1,el2,className){
    if(el1.classList.contains(className)){
        el1.classList.remove(className)
        el2.classList.add(className)
        return
    }
    el1.classList.add(className)
    el2.classList.remove(className)
}

if(bookmarkCalendarButton){
    bookmarkCalendarButton.onclick = ()=>{
        if(bookmarkCalendar.classList.contains("hidden")){
            swapClasses(bookmarkCalendar,bookmarkInfo, "hidden")
            swapClasses(bookmarkInfoButton, bookmarkCalendarButton, "checked")
        }
    }
}


if(bookmarkInfo){
    bookmarkInfoButton.onclick = ()=>{
        if(bookmarkInfo.classList.contains("hidden")){
            swapClasses(bookmarkInfo,bookmarkCalendar, "hidden")
            swapClasses(bookmarkCalendarButton,bookmarkInfoButton, "checked")
        }
    }
}

if(bookBillboard){
    bookBillboard.onclick = ()=>{
        if(!billboardModal.classList.contains("visible")){
            billboardModal.classList.add("visible")
            document.body.style.overflow = "hidden"
            billboardModal.onclick = (ev)=>{
                if(ev.path.indexOf(document.querySelector(".sectionForm")) == -1 && ev.path.indexOf(document.querySelector(".sectionInfo")) == -1){
                    billboardModal.classList.remove("visible")
                    document.body.style.overflowY = "scroll"
                }
            }
        }
    }
}

