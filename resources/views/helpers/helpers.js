/*
   add your app helper functions here
 */


export const currencyFormatter = (num) => {
    if (!isNaN(num)) {
        num = parseFloat(num);
        return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    } else {
        return num;
    }
}
export const dateFormatter = (dateStr) => {
    return new Date(dateStr)
        .toLocaleDateString("en-GB", {
            day: "numeric",
            month: "long",
            year: "numeric"
        });
}
