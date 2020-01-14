/**
 * Check if provided date is not from future
 * @param e - onchange event
 */
function validateDate(e){
    date = e.target.value
    inputDate = new Date(date)
    today = new Date()
    if(inputDate>today){
        alert(`You provided date from future. Today is ${today.toDateString()}. Not ${inputDate.toDateString()}`)
        setDateToToday(e.target.id)
    }
}

/**
 * Checks if provided date is not from future
 * @param e - onchange event
 */
function validateTime(e){
    time = e.target.value
    const placeholderDate = '10/10/2000 '
    today= new Date()    
    inputTime = new Date(placeholderDate + time)
    todayTime = new Date(placeholderDate + today.toLocaleTimeString())
    if(inputTime>todayTime){
        alert(`You provided time from future. Now is ${today.toLocaleTimeString()}. Not ${inputTime.toLocaleTimeString()}`)
        setTimeToCurrent(e.target.id)
    }
}