import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';
import { tableCompanyData } from '@app/mock-data/data/table';

const companyData = tableCompanyData as any[];

export class Page {
    size: number = 0;
    totalElements: number = 0;
    totalPages: number = 0;
    pageNumber: number = 0;
}

export class PagedData<T> {
    data = new Array<T>();
    page = new Page();
}

export class CorporateEmployee {
    name: string;
    gender: string;
    company: string;
    age: number;
  
    constructor(name: string, gender: string, company: string, age: number) {
        this.name = name;
        this.gender = gender;
        this.company = company;
        this.age = age;
    }
}

@Injectable({
    providedIn: 'root'
})
export class MockServerResultsService {
    public getResults(page: Page): Observable<PagedData<CorporateEmployee>> {
        return of(companyData).pipe(map(d => this.getPagedData(page)));
    }
    private getPagedData(page: Page): PagedData<CorporateEmployee> {
        const pagedData = new PagedData<CorporateEmployee>();
        page.totalElements = companyData.length;
        page.totalPages = page.totalElements / page.size;
        const start = page.pageNumber * page.size;
        const end = Math.min(start + page.size, page.totalElements);
        for (let i = start; i < end; i++) {
            const jsonObj = companyData[i];
            const employee = new CorporateEmployee(jsonObj.name, jsonObj.gender, jsonObj.company, jsonObj.age);
            pagedData.data.push(employee);
        }
        pagedData.page = page;
        return pagedData;
    }
}