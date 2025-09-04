export function normalizeUnit(unit: string): string {
    const normalizedUnits: { [key: string]: string } = {
        'kg': 'kilogram',
        'g': 'gram',
        'l': 'liter',
        'ml': 'milliliter',
        'm': 'meter',
        'cm': 'centimeter',
        'mm': 'millimeter',
        'pcs': 'pieces',
        'box': 'boxes',
        'bottle': 'bottles',
    };

    return normalizedUnits[unit.toLowerCase()] || unit;
}

export function convertToBaseUnit(value: number, unit: string): number {
    const conversionFactors: { [key: string]: number } = {
        'kg': 1000,
        'g': 1,
        'l': 1000,
        'ml': 1,
        'm': 1,
        'cm': 0.01,
        'mm': 0.001,
        'pcs': 1,
        'box': 1, // Assuming 1 box is 1 unit for simplicity
        'bottle': 1, // Assuming 1 bottle is 1 unit for simplicity
    };

    return value * (conversionFactors[unit.toLowerCase()] || 1);
}