export function normalizeCurrency(value: string): number {
    const cleanedValue = value.replace(/[^0-9.-]+/g, "");
    const parsedValue = parseFloat(cleanedValue);
    return isNaN(parsedValue) ? 0 : parsedValue;
}

export function formatCurrency(value: number, currencySymbol: string = '$'): string {
    return `${currencySymbol}${value.toFixed(2)}`;
}