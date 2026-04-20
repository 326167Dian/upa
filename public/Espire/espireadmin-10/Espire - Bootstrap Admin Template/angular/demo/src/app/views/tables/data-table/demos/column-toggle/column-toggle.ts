import { Component, OnInit } from '@angular/core';
import { ColumnMode } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-column-toggle',
    templateUrl: 'column-toggle.html'
})

export class DemoDataTableColumnToggleComponent implements OnInit {
    rows = [
        {
            name: 'Claudine Neal',
            gender: 'female',
            company: 'Sealoud'
        },
        {
            name: 'Beryl Rice',
            gender: 'female',
            company: 'Velity'
        }
    ];

    columns = [{ name: 'Name' }, { name: 'Gender' }, { name: 'Company' }];

    allColumns = [{ name: 'Name' }, { name: 'Gender' }, { name: 'Company' }];


    ColumnMode = ColumnMode;

    constructor() { }

    ngOnInit() { }

    toggle(col) {
        const isChecked = this.isChecked(col);

        if (isChecked) {
            this.columns = this.columns.filter(c => {
                return c.name !== col.name;
            });
        } else {
            this.columns = [...this.columns, col];
        }
    }

    isChecked(col) {
        return (
            this.columns.find(c => {
                return c.name === col.name;
            }) !== undefined
        );
    }
}