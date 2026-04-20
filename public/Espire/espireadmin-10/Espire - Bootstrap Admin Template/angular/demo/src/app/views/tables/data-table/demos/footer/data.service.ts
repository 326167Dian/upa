import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

interface TableData {
    name: string;
    gender: string;
    company: string
}

@Injectable({
    providedIn: 'root'
})
export class TableDataService {
    apiUrl = `/api/table/company`;

    constructor(private http: HttpClient) {}

    public getData() {
        return this.http.get<Array<TableData>>(this.apiUrl);
    }
}