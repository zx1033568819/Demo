var arr=[1,2,3,5,1,6,7]
function delrepeat(arr){
    for(var i=0,i<arr.length-1,i++)
    {
        for(var j=i+1,j<arr.length,j++)
        {
            if(arr[j]==arr[i])
            {
                arr.splice(j,1);
                j--;
            }
        }
    }
    return arr;
}
arr2=delrepeat(arr);
console.log(arr);
console.log(arr2);