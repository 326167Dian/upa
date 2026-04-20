import { Component, OnInit } from '@angular/core';
import { ColumnMode, SortType } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-sorting',
    templateUrl: 'sorting.html'
})

export class DemoDataTableSortingComponent implements OnInit {
    rows = [
        { name: 'Austin', gender: 'Male', company: 'Swimlane' },
        { name: 'Dany', gender: 'Male', company: 'KFC' },
        { name: 'Molly', gender: 'Female', company: 'Burger King' }
    ];;

    columns = [{ name: 'Company' }, { name: 'Name' }, { name: 'Gender' }];

    ColumnMode = ColumnMode;
    SortType = SortType;


    constructor() {
    }

    ngOnInit() { }
}