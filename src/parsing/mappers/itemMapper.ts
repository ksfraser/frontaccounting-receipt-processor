export interface Item {
    id: string;
    name: string;
    quantity: number;
    price: number;
}

export function mapItemData(parsedData: any): Item {
    return {
        id: parsedData.itemId,
        name: parsedData.itemName,
        quantity: parsedData.itemQuantity,
        price: parsedData.itemPrice,
    };
}