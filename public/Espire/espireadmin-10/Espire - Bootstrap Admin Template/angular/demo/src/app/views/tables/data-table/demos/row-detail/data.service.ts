import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

interface Address {
    state: string;
    city: string
}

interface User {
    id: number;
    name: string;
    gender: string;
    age: number,
    address: Address
}

@Injectable({
    providedIn: 'root'
})
export class TableDataService {
    apiUrl = `/api/table/row`;

    constructor(private http: HttpClient) {}

    public getData() {
        return this.http.get<Array<User>>(this.apiUrl);
    }
}