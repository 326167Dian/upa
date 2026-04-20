import { Component, OnInit } from '@angular/core';
import { ColumnMode } from '@swimlane/ngx-datatable';
import { MockServerResultsService, CorporateEmployee, Page } from  './data.service';
import { delay } from 'rxjs/operators';

interface PageInfo {
    offset: number;
    pageSize: number;
    limit: number;
    count: number;
}

@Component({
    selector: 'demo-data-table-virtual',
    templateUrl: 'virtual.html'
})

export class DemoDataTableVirtualComponent implements OnInit {

    totalElements: number;
    pageNumber: number;
    rows: CorporateEmployee[];
    cache: any = {};

    ColumnMode = ColumnMode;

    isLoading = 0;

    constructor(private serverResultsService: MockServerResultsService) {
        this.pageNumber = 0;
    }

    ngOnInit(): void {
    }

    setPage(pageInfo: PageInfo) {
        // current page number is determined by last call to setPage
        this.pageNumber = pageInfo.offset;

        // don't load same data twice
        if (this.cache[pageInfo.offset]) return;
        this.cache[pageInfo.offset] = true;

        // counter of pages loading
        this.isLoading++;

        // class to idendify loading page
        const page = new Page();
        page.pageNumber = pageInfo.offset;
        page.size = pageInfo.pageSize;

        this.serverResultsService
            .getResults(page)
            .pipe(delay(new Date(Date.now() + 1000 * Math.random()))) // simulating variability in returned data
            .subscribe(pagedData => {
                // update total count
                this.totalElements = pagedData.page.totalElements;

                // create array to store data if missing
                if (!this.rows) {
                // length should be total count
                this.rows = new Array<CorporateEmployee>(pagedData.page.totalElements || 0);
                }

                // calc starting index
                const start = pagedData.page.pageNumber * pagedData.page.size;

                // copy existing data
                const rows = [...this.rows];

                // insert new rows into new position
                rows.splice(start, pagedData.page.size, ...pagedData.data);

                // set rows to our new rows
                this.rows = rows;

                this.isLoading--;
        });
    }
}