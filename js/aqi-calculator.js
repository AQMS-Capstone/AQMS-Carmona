/**
 * Created by Skullpluggery on 11/9/2016.
 */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var calculator_mode = getUrlParameter('calculator');
$( document ).ready(function(){

    if(calculator_mode == "CVA"){
        GetElementInfoAQI();
    }else if(calculator_mode == "ACV"){
        GetElementInfoCV();
    }
})


function InitAQICalculator(){

    $("#txtTitle").text('AQI Calculator');
    $("#txtConversion").text('Concentration');

    $('select[id=element]').change(function () {

        GetElementInfoAQI();
    });
}

function GetElementInfoAQI(){
    if($('#element').val() == "CO" || $('#element').val() == "SO2" || $('#element').val() == "NO2" || $('#element').val() == "O3_8" || $('#element').val() == "O3_1" )
    {
        if($('#element').val() == "CO")
        {
            $("#concentration").attr({
                "min" : co_min,
                "max" : co_max,
                "step" : co_step
            });

            $('#unit').text("ppm");
        }

        if($('#element').val() == "SO2")
        {
            if(unit_used == "old") {
                $("#concentration").attr({
                    "min": sulfur_min,
                    "max": sulfur_max,
                    "step": sulfur_step
                });

                $('#unit').text("ppm");
            }else{
                $("#concentration").attr({
                    "min": sulfur_min,
                    "max": sulfur_max,
                    "step": sulfur_step
                });
                $('#unit').text("ppb");
            }
        }

        if($('#element').val() == "NO2")
        {
            if(unit_used == "old") {
                $("#concentration").attr({
                    "step": no2_step,
                    "min": no2_min,
                    "max": no2_max
                });

                $('#unit').text("ppm");
            }else{
                $("#concentration").attr({
                    "step": no2_step,
                    "min": no2_min,
                    "max": no2_max
                });
                $('#unit').text("ppb");
            }
        }
        if($('#element').val() == "O3_8")
        {
            $("#concentration").attr({
                "min" : o3_min,
                "max" : o3_max,
                "step" : o3_step
            });

            $('#unit').text("ppm");
        }
        if($('#element').val() == "O3_1")
        {
            $("#concentration").attr({
                "min" : o3_min,
                "max" : o3_max,
                "step" : o3_step
            });

            $('#unit').text("ppm");
        }
    }
    else{
        if($('#element').val() == "PM 10")
        {
            $("#concentration").attr({
                "min" : pm10_min,
                "max" : pm10_max,
                "step" : 1
            });
        }
        if($('#element').val() == "TSP")
        {
            $("#concentration").attr({
                "min" : tsp_min,
                "max" : 999999,
                "step" : 1
            });
        }

        $('#unit').text("ug/m3");
    }
}

function GetElementInfoCV(){

    //CHANGE THIS LATER ON HA PAG GINAWANG OLD

    if(unit_used == "old") {
        $('select[id=element]').change(function () {

            if ($('#element').val() == "O3_8") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 300
                });
            }
            if ($('#element').val() == "O3_1") {
                $("#concentration").attr({
                    "min": 101,
                    "max": 400,
                });
            }
            if ($('#element').val() == "PM 10") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "CO") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "SO2") {
                $("#concentration").attr({
                    "min": 101,
                    "max": 400,
                });
            }
            if ($('#element').val() == "NO2") {
                $("#concentration").attr({
                    "min": 201,
                    "max": 400,
                });
            }
            if ($('#element').val() == "TSP") // CHECK
            {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }

            $('#unit').text("AQI");
        });
    }else{
        $('select[id=element]').change(function () {

            if ($('#element').val() == "O3_8") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 300
                });
            }
            if ($('#element').val() == "O3_1") {
                $("#concentration").attr({
                    "min": 101,
                    "max": 400,
                });
            }
            if ($('#element').val() == "PM 10") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "CO") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "SO2") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "NO2") {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }
            if ($('#element').val() == "TSP") // CHECK
            {
                $("#concentration").attr({
                    "min": 0,
                    "max": 400,
                });
            }

            $('#unit').text("AQI");
        });
    }
}

function InitCVCalculator(){

    $("#txtTitle").text('Concentration Value Calculator');
    $("#txtConversion").text('AQI');
    $("#unit").hide();

    $('select[id=element]').change(function () {

        GetElementInfoCV();
    });

}

function GetAQIDetails(AQI,element){
    if(element == "TSP")
    {
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
        }else if(AQI > 400){
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

    else{
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
}

function GetStatement(AQIStatus,element){
    switch (AQIStatus){
        case "No Current Data":{
            break;
        }
        case "Good":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
            }
            break;
        }

        case "Fair":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk");
                    $("#health-effects").text("");
                    $("#cautionary").text("Unusually sensitive individuals should consider limiting prolonged exertion especially near busy roads.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Unusually sensitive individuals may experience respiratory symptoms.");
                    $("#cautionary").text("Unusually sensitive people should consider limiting prolonged outdoor exertion.");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk ");
                    $("#health-effects").text("Unusually sensitive individuals may experience respiratory symptoms.");
                    $("#cautionary").text("Unusually sensitive people should consider reducing prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("");
                    $("#cautionary").text("");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk");
                    $("#health-effects").text("Respiratory symptoms possible in unusually sensitive individuals, possible aggravation of heart or lung disease in people with cardiopulmonary disease and older adults.");
                    $("#cautionary").text("Unusually sensitive people should consider reducing prolonged or heavy exertion.");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk");
                    $("#health-effects").text("Respiratory symptoms possible in unusually sensitive individuals, possible aggravation of heart or lung disease in people with cardiopulmonary disease and older adults.");
                    $("#cautionary").text("Unusually sensitive people should consider reducing prolonged or heavy exertion.");
                    break;
                }
            }
            break;
        }

        case "Unhealthy for Sensitive Groups":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Increasing likelihood of reduced exercise tolerance due to increased cardiovascular symptoms, such as chest pain, in people with heart disease.");
                    $("#cautionary").text("People with heart disease, such as angina, should limit heavy exertion and avoid sources of CO, such as heavy traffic");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms, such as chest tightness and breathing discomfort, in people with asthma.");
                    $("#cautionary").text("People with asthma should consider limiting outdoor exertion");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms, such as chest tightness and breathing discomfort, in people with asthma.");
                    $("#cautionary").text("People with asthma, children and older adults should limit prolonged exertion especially near busy roads.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms and breathing discomfort in active children and adults and people with lung disease, such as asthma.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should reduce prolonged or heavy outdoor exertion. ");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms and breathing discomfort in active children and adults and people with lung disease, such as asthma.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should reduce prolonged or heavy outdoor exertion. ");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms and breathing discomfort in active children and adults and people with lung disease, such as asthma.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should reduce prolonged or heavy outdoor exertion. ");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms in sensitive individuals, aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults.");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should reduce prolonged or heavy exertion");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Increasing likelihood of respiratory symptoms in sensitive individuals, aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults.");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should reduce prolonged or heavy exertion");
                    break;
                }
            }
            break;
        }

        case "Very Unhealthy":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Reduced exercise tolerance due to increased cardiovascular symptoms, such as chest pain, in people with heart disease.");
                    $("#cautionary").text("People with heart disease, such as angina, should limit moderate exertion and avoid sources of CO, such as heavy traffic.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Increased respiratory symptoms, such as chest tightness and wheezing in people with asthma; possible aggravation of heart or lung disease.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should limit outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk.");
                    $("#health-effects").text("Increased respiratory symptoms, such as chest tightness and wheezing in people with asthma; possible aggravation of other lung diseases.");
                    $("#cautionary").text("People with asthma, children and older adults should avoid prolonged exertion near roadways; everyone else should limit prolonged exertion especially near busy roads.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Greater likelihood of respiratory symptoms and breathing difficulty in active children and adults and people with lung disease, such as asthma; possible respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should avoid prolonged or heavy outdoor exertion; everyone else, especially children, should reduce prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Greater likelihood of respiratory symptoms and breathing difficulty in active children and adults and people with lung disease, such as asthma; possible respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should avoid prolonged or heavy outdoor exertion; everyone else, especially children, should reduce prolonged or heavy outdoor exertion.");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Greater likelihood of respiratory symptoms and breathing difficulty in active children and adults and people with lung disease, such as asthma; possible respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should avoid prolonged or heavy outdoor exertion; everyone else, especially children, should reduce prolonged or heavy outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Increased aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; increased respiratory effects in general population. ");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should reduce prolonged or heavy exertion.");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Increased aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; increased respiratory effects in general population. ");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should reduce prolonged or heavy exertion.");
                    break;
                }
            }
            break;
        }

        case "Acutely Unhealthy":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Significant aggravation of cardiovascular symptoms, such as chest pain, in people with heart disease");
                    $("#cautionary").text("People with heart disease, such as angina, should limit moderate exertion and avoid sources of CO, such as heavy traffic.");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Significant increase in respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; aggravation of heart or lung disease.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should limit outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk.");
                    $("#health-effects").text("Significant increase in respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; aggravation of other lung diseases.");
                    $("#cautionary").text("People with asthma, children and older adults should avoid prolonged exertion near roadways; everyone else should limit prolonged exertion especially near busy roads.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk ");
                    $("#health-effects").text("Increasingly severe symptoms and impaired breathing likely in active children and adults and people with lung disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should avoid all outdoor exertion; everyone else, especially children, should reduce outdoor exertion.");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk ");
                    $("#health-effects").text("Increasingly severe symptoms and impaired breathing likely in active children and adults and people with lung disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("Active children and adults, and people with lung disease, such as asthma, should avoid all outdoor exertion; everyone else, especially children, should reduce outdoor exertion.");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("AA People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk ");
                    $("#health-effects").text("AA Increasingly severe symptoms and impaired breathing likely in active children and adults and people with lung disease, such as asthma; increasing likelihood of respiratory effects in general population.");
                    $("#cautionary").text("AA Active children and adults, and people with lung disease, such as asthma, should avoid all outdoor exertion; everyone else, especially children, should reduce outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Significant aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; significant increase in respiratory effects in general population.");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Significant aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; significant increase in respiratory effects in general population.");
                    $("#cautionary").text("People with heart or lung disease, older adults, and children should avoid all physical activity outdoors. Everyone else should avoid prolonged or heavy exertion.");
                    break;
                }
            }
            break;
        }

        case "Emergency":{
            switch (element){
                case "CO":{
                    $("#synthesis").text("People with heart disease are the group most at risk.");
                    $("#health-effects").text("Serious aggravation of cardiovascular symptoms, such as chest pain, in people with heart disease; impairment of strenuous activities in general population.");
                    $("#cautionary").text("People with heart disease, such as angina, should avoid exertion and sources of CO, such as heavy traffic; everyone else should limit heavy exertion");
                    break;
                }
                case "SO2":{
                    $("#synthesis").text("People with asthma are the group most at risk.");
                    $("#health-effects").text("Severe respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; increased aggravation of heart or lung disease; possible respiratory effects in general population.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should remain indoors; everyone else should avoid outdoor exertion.");
                    break;
                }
                case "NO2":{
                    $("#synthesis").text("People with asthma, children, and older adults are the groups most at risk");
                    $("#health-effects").text("Severe respiratory symptoms, such as wheezing and shortness of breath, in people with asthma; increased aggravation of heart or lung disease; possible respiratory effects in general population.");
                    $("#cautionary").text("Children, asthmatics, and people with heart or lung disease should remain indoors; everyone else should avoid outdoor exertion.");
                    break;
                }
                case "O3":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid all outdoor exertion.");
                    break;
                }
                case "O3_8":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid all outdoor exertion.");
                    break;
                }
                case "O3_1":{
                    $("#synthesis").text("People with lung disease, children, older adults, and people who are active outdoors are the groups most at risk.");
                    $("#health-effects").text("Severe respiratory effects and impaired breathing likely in active children and adults and people with respiratory disease, such as asthma; increasingly severe respiratory effects likely in general population.");
                    $("#cautionary").text("Everyone should avoid all outdoor exertion.");
                    break;
                }
                case "PM 10":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Serious aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; serious risk of respiratory effects in general population.");
                    $("#cautionary").text("Everyone should avoid all physical activity outdoors people with heart or lung disease, older adults, and children should remain indoors and keep activity levels low.");
                    break;
                }
                case "TSP":{
                    $("#synthesis").text("People with heart or lung disease, older adults, and children and the groups most at risk ");
                    $("#health-effects").text("Serious aggravation of heart or lung disease and premature mortality in people with cardiopulmonary disease and older adults; serious risk of respiratory effects in general population.");
                    $("#cautionary").text("Everyone should avoid all physical activity outdoors people with heart or lung disease, older adults, and children should remain indoors and keep activity levels low.");
                    break;
                }
            }
            break;
        }
    }
}

