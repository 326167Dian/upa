import { Component, OnInit } from '@angular/core';
import { TableDataService } from  './data.service';
import { ColumnMode } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-tree',
    templateUrl: 'tree.html'
})

export class DemoDataTableTreeComponent implements OnInit {
    rows = [];

    ColumnMode = ColumnMode;

    ngOnInit(): void { }

    constructor(private tableSvc: TableDataService) {
       this.fetch()
    }

    fetch() {
        this.tableSvc.getData().subscribe(data => {
            this.rows = data
        });
    }

    onTreeAction(event: any) {
        const index = event.rowIndex;
        const row = event.row;
        if (row.treeStatus === 'collapsed') {
            row.treeStatus = 'expanded';
        } else {
            row.treeStatus = 'collapsed';
        }
        this.rows = [...this.rows];
    }
}