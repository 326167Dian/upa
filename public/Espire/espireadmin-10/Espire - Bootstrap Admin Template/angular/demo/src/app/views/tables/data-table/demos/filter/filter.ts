import { Component, OnInit, ViewChild } from '@angular/core';
import { DatatableComponent } from '@swimlane/ngx-datatable';
import { TableDataService } from  './data.service';

@Component({
    selector: 'demo-data-table-filter',
    templateUrl: './filter.html',
    providers: [
        TableDataService
    ],
})
export class DemoDataTableFilterComponent implements OnInit {
    rows = [];
    temp = [];
    columns = [{ prop: 'name' }, { name: 'Company' }, { name: 'Gender' }];

    @ViewChild(DatatableComponent) table: DatatableComponent;

    constructor(private tableSvc: TableDataService) {
        this.fetch()
    }

    ngOnInit(): void { }

    fetch() {
        this.tableSvc.getData().subscribe(data => {
            this.temp = [...data]
            this.rows = data
        });
    }

    updateFilter(event) {
        const val = event.target.value.toLowerCase();

        // filter our data
        const temp = this.temp.filter(function (d) {
            return d.name.toLowerCase().indexOf(val) !== -1 || !val;
        });

        // update the rows
        this.rows = temp;
        // Whenever the filter changes, always go back to the first page
        this.table.offset = 0;
    }
}
