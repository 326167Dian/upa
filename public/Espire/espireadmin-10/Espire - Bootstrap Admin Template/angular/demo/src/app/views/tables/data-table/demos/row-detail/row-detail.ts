import { Component, OnInit, ViewChild } from '@angular/core';
import { ColumnMode } from '@swimlane/ngx-datatable';
import { TableDataService } from  './data.service';

@Component({
    selector: 'demo-data-table-row-detail',
    templateUrl: 'row-detail.html'
})

export class DemoDataTableRowDetailComponent implements OnInit {
    @ViewChild('myTable') table: any;

    rows: any[] = [];
    expanded: any = {};
    timeout: any;

    ColumnMode = ColumnMode;

    constructor(private tableSvc: TableDataService) {
        this.fetch();
    }

    onPage(event) {
        clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
            console.log('paged!', event);
        }, 100);
    }

    fetch() {
        this.tableSvc.getData().subscribe(data => {
            this.rows = data
        });
    }
    toggleExpandRow(row) {
        console.log('Toggled Expand Row!', row);
        this.table.rowDetail.toggleExpandRow(row);
    }

    onDetailToggle(event) {
        console.log('Detail Toggled', event);
    }

    ngOnInit() { }
}