import { Component, OnInit } from '@angular/core';
import { ColumnMode } from '@swimlane/ngx-datatable';
import { TableDataService } from  './data.service';

@Component({
    selector: 'data-table-column-pinning',
    templateUrl: 'column-pinning.html'
})

export class DemoDataTableColumnPinningComponent implements OnInit {

    rows = [];

    ColumnMode = ColumnMode;


    constructor(private tableSvc: TableDataService) {
        this.fetch()
    }

    ngOnInit(): void { }

    fetch() {
        this.tableSvc.getData().subscribe(data => {
            this.rows = data
        });
    }
}