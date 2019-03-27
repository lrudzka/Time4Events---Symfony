document.addEventListener("DOMContentLoaded", function()

{
    
    if (document.getElementById("category") )
    {
        var $category = document.getElementById("category").innerHTML;

        var $categoryField = document.getElementById("event_category");

        $categoryField.value = $category;

    }

    if (document.getElementById("province") )
    {
        var $province = document.getElementById("province").innerHTML;

        var $provinceField = document.getElementById("event_province");

        $provinceField.value = $province;
    }
    
    if (document.getElementById("startsAt")) 
    {
        var $startsAt = document.getElementById("startsAt");
        
        var $startsAtYearField = document.getElementById("event_startsAt_date_year");
        
        $startsAtYearField.value = $startsAt.innerHTML.substr(0,4);
        
        var $startsAtMonthField = document.getElementById("event_startsAt_date_month");
        
        $startsAtMonthField.value = Number($startsAt.innerHTML.substr(5,2));
        
        var $startsAtDayField = document.getElementById("event_startsAt_date_day");
        
        $startsAtDayField.value = Number($startsAt.innerHTML.substr(8,2));
        
        var $startsAtHourField = document.getElementById("event_startsAt_time_hour");
        
        $startsAtHourField.value = Number($startsAt.innerHTML.substr(11,2));
        
        var $startsAtMinField = document.getElementById("event_startsAt_time_minute");
        
        $startsAtMinField.value = Number($startsAt.innerHTML.substr(14,2));
        
           
    }
    
    if (document.getElementById("endsAt")) 
    {
        var $endsAt = document.getElementById("endsAt");
        
        var $endsAtYearField = document.getElementById("event_endsAt_date_year");
        
        $endsAtYearField.value = $endsAt.innerHTML.substr(0,4);
        
        var $endsAtMonthField = document.getElementById("event_endsAt_date_month");
        
        $endsAtMonthField.value = Number($endsAt.innerHTML.substr(5,2));
        
        var $endsAtDayField = document.getElementById("event_endsAt_date_day");
        
        $endsAtDayField.value = Number($endsAt.innerHTML.substr(8,2));
        
        var $endsAtHourField = document.getElementById("event_endsAt_time_hour");
        
        $endsAtHourField.value = Number($endsAt.innerHTML.substr(11,2));
        
        var $endsAtMinField = document.getElementById("event_endsAt_time_minute");
        
        $endsAtMinField.value = Number($endsAt.innerHTML.substr(14,2));
        
           
    }
    
    if (document.getElementById("addForm"))
    {
        var $endsAtMinField = document.getElementById("event_endsAt_time_minute");
        
        $endsAtMinField.value=0;
        
        var $startsAtMinField = document.getElementById("event_startsAt_time_minute");
        
        $startsAtMinField.value=0;
        
        
    }
    
       


});



