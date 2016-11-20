/**
 * Created by Skullpluggery on 11/9/2016.
 */

function GetAQIDetails(AQI,element){
    if(AQI >= 0 && AQI <= 50){
        AQIAirQuality = goodAir;
        AQIStatus = "Good";
    }else if(AQI >= 51 && AQI <= 100)
    {
        AQIAirQuality = fairAir;
        AQIStatus = "Fair";
    }else if(AQI >= 101 && AQI <= 150)
    {
        AQIAirQuality = unhealthyAir;
        AQIStatus = "Unhealthy for Sensitive Groups";
    }else if(AQI >= 151 && AQI <= 200)
    {
        AQIAirQuality = veryUnhealthyAir;
        AQIStatus = "Very Unhealthy";
    }else if(AQI >= 201 && AQI <= 300)
    {
        AQIAirQuality = acutelyUnhealthyAir;
        AQIStatus = "Acutely Unhealthy";
    }else if(AQI >= 301 && AQI <= 400)
    {
        AQIAirQuality = emergencyAir;
        AQIStatus = "Emergency";
    }else if(AQI == -1){
        AQIAirQuality = otherAir;
        AQIStatus = "No Current Data";
    }
    else{
        AQIAirQuality = otherAir;
        AQIStatus = "No Current Data";
    }

    GetStatement(AQIStatus,element);
}

function GetStatement(AQIStatus,element){

    switch (AQIStatus){
        case "No Current Data":{

            break;
        }
        case "Good":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "TSP":{

                    break;
                }
            }
            break;
        }
        case "Fair":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("Unusually sensitive individuals may experience respiratory symptoms.");
                    $("#cautionary").text("Unusually sensitive people should consider reducing prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("Unusually sensitive individuals may experience respiratory symptoms.");
                    $("#cautionary").text("Unusually sensitive people should consider limiting prolonged outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("Unusually sensitive people should consider reducing prolonged or heavy exertion.");
                    $("#cautionary").text("Unusually sensitive people should consider reducing prolonged or heavy exertion.");
                    break;
                }
                case "TSP":{
                    break;
                }
            }
            break;
        }
        case "Unhealthy for Sensitive Groups":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms, such as chest tightness and breathing discomfort, in people with asthma.");
                    $("#cautionary").text("People with asthma should consider limiting outdoor exertion.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Increasing likelihood of reduced exercise tolerance due to increased cardiovascular symptoms, such as chest pain, in people with cardiovascular disease.");
                    $("#cautionary").text("People with cardiovascular disease, such as angina, should limit heavy exertion and avoid sources of SO2, such as heavy traffic.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms and breathing discomfort in active children, the elderly, and people with lung disease, such as asthma.");
                    $("#cautionary").text("Active children, the elderly, and people with lung disease, such as asthma, should reduce prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms and breathing discomfort in active children and adults and people with respiratory disease, such as asthma.");
                    $("#cautionary").text("Active children and adults, and people with respiratory disease, such as asthma, should limit prolonged outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptomsand aggravationof lung disease, such as asthma.");
                    $("#cautionary").text("People with respiratorydisease, such as asthma, should limit outdoor exertion.");
                    break;
                }
                case "TSP":{
                    break;
                }
            }
            break;
        }
        case "Very Unhealthy":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Reduced exercise tolerance due to increased cardiovascular symptoms, such as chest pain, in people with cardiovascular disease.");
                    $("#cautionary").text("People with cardiovascular disease, such as angina, should limit moderate exertion and avoid sources of CO, such as heavy traffic.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Significant increase in respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; aggravation of heart or lung disease.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should avoid outdoor exertion; everyone else should limit outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("Greater likelihood of respiratory symptoms in active children, the elderly, and people with lung disease, such as asthma; possible respiratory effects in general population.");
                    $("#cautionary").text("Active children, the elderly, and people with lung disease, such as asthma, should avoid prolonged or heavy outdoor exertion; everyone else, expecially children, should reduce prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("Increasingly severe symptoms and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with respiratory disease, such as asthma, should avoid all outdoor exertion; everyone else, especially children, should limit outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("Increased respiratory symptoms and aggravation of lung disease, such as asthma; possible respiratory effects in general population.");
                    $("#cautionary").text("People with respiratory disease, such as asthma, should avoid any outdoor activity; everyone else, especially the elderly and children, should limit outdoor exertion.");
                    break;
                }
                case "TSP":{
                    break;
                }
            }
            break;
        }
        case "Acutely Unhealthy":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Significant aggravation of cardiovascular symptoms, such as chest pain, in people with cardiovascular disease.");
                    $("#cautionary").text("People with cardiovascular disease, such as angina, should avoid exertion and sources of CO, such as heavy traffic.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Increased respiratory symptoms, such as chest tightness and wheezing in people with asthma; possible aggravation of heart or lung disease.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should limit outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("Increasingly severe symptoms and impaired breathing likely in active children, the elderly, and people with lung disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("Active children, the elderly, and people with lung disease, such as asthma, should avoid all outdoor exertion; everyone else, especially children, should avoid prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid all outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("Significant increase in respiratory symptoms and aggravation of lung disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("People with respiratory disease, such as asthma, should avoid any outdoor activity; everyone else, especially the elderly and children, should limit outdoor exertion.");
                    break;
                }
                case "TSP":{
                    break;
                }
            }
            break;
        }
        case "Emergency":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Serious aggravation of cardiovascular symptoms, such as chest pain, in people with cardiovascular disease; impairment of strenuous activities in general population.");
                    $("#cautionary").text("People with cardiovascular disease, such as angina, should avoid exertion and sources of CO, such as heavy traffic; everyone else should limit heavy exertion.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Severe respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; increased aggravation of heart or lung disease; possible respiratory effects in general population.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should remain indoors; everyone else should avoid outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma or other respiratory diseases, the elderly, and children are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children, the elderly, and people with lung disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Children, the elderly, and people with lung disease, such as asthma, should remain indoors; everyone else, especially children, should avoid outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("Children and people with asthma are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid all outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with respiratory disease are the group most at risk.");
                    $("#health-effects").text("Serious risk of respiratory symptoms and aggravation of lung disease, such as asthma; respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid any outdoor exertion; people with respiratory disease, such as asthma, should remain indoors.");
                    break;
                }
                case "TSP":{
                    break;
                }
            }
            break;
        }
    }
}

$('select[id=element]').change(function () {

    if($('#element').val() == "CO" || $('#element').val() == "SO2" || $('#element').val() == "NO2" || $('#element').val() == "O3_8" || $('#element').val() == "O3_1" )
    {
        if($('#element').val() == "CO")
        {
            $("#concentration").attr({
                "min" : 0.0,
                "max" : 40.4,
                "step" : 0.1
            });
        }

        if($('#element').val() == "SO2")
        {
            $("#concentration").attr({
                "min" : 0.000,
                "max" : 0.804,
                "step" : 0.001
            });
        }
        if($('#element').val() == "NO2")
        {
            $("#concentration").attr({
                "min" : 0.65,
                "max" : 1.64,
                "step" : 0.1
            });
        }
        if($('#element').val() == "O3_8")
        {
            $("#concentration").attr({
                "min" : 0.000,
                "max" : 0.504,
                "step" : 0.001
            });
        }
        if($('#element').val() == "O3_1")
        {
            $("#concentration").attr({
                "min" : 0.000,
                "max" : 0.504,
                "step" : 0.001
            });
        }



        $('#unit').text("ppm");
    }
    else{
        if($('#element').val() == "PM10")
        {
            $("#concentration").attr({
                "min" : 0,
                "max" : 504,
                "step" : 1
            });
        }
        if($('#element').val() == "TSP")
        {
            $("#concentration").attr({
                "min" : 0,
                "step" : 1
            });
        }
        $('#unit').text("ug/m3");
    }
});