import { Component, OnInit } from '@angular/core';
import { ColumnMode, SelectionType } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-cell-select',
    templateUrl: 'cell-select.html'
})

export class DemoDataTableCellSelectComponent implements OnInit {
    rows = [
        { name: 'Austin', gender: 'Male', company: 'Swimlane' },
        { name: 'Dany', gender: 'Male', company: 'KFC' },
        { name: 'Molly', gender: 'Female', company: 'Burger King' }
    ];
    selected: any[] = [];
    columns: any[] = [{ prop: 'name' }, { name: 'Company' }, { name: 'Gender' }];

    ColumnMode = ColumnMode;
    SelectionType = SelectionType;

    constructor() { }

    ngOnInit() { }

    onSelect(event) {
        console.log('Event: select', event, this.selected);
    }
    
    onActivate(event) {
        console.log('Event: activate', event);
    }
}