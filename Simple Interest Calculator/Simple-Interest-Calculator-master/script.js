function validateForm() {
    var user = document.getElementById("principal");
    if ( user.value <= 0 ) {
        alert("Enter a positive number");
        return false;
    }
    return result();
}

function compute()
{
    p = document.getElementById("principal").value;

}


function updateRate()
{
    var rateval = document.getElementById("rate").value;
    document.getElementById("rate_val").innerText=rateval +"%";
}

function result(){
    var principal = document.getElementById("principal").value;
    var rate = document.getElementById("rate").value;
    var years = document.getElementById("years").value;
    var interest = principal * years * rate /100;
    var year = 2022 ;
    year = year + Number (years);

    document.getElementById("result").innerHTML="If you deposit \<mark>"  +principal+ "\</mark>,\<br\>at an interest rate of \<mark>"+rate+"%\</mark> \<br\>You will receive an amount of \<mark>"+interest+"\</mark>,\<br\>in the year \<mark> "+year+"\</mark>\<br\>" ;
    return false;
}
