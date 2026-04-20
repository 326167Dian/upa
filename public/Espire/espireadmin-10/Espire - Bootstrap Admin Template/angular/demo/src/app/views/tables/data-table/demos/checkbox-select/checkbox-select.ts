import { Component, OnInit } from '@angular/core';
import { ColumnMode, SelectionType } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-checkbox-select',
    templateUrl: 'checkbox-select.html'
})

export class DemoDataTableCheckboxSelectComponent implements OnInit {

    rows = [
        { name: 'Austin', gender: 'Male', company: 'Swimlane' },
        { name: 'Dany', gender: 'Male', company: 'KFC' },
        { name: 'Molly', gender: 'Female', company: 'Burger King' }
    ];
    selected = [];

    ColumnMode = ColumnMode;
    SelectionType = SelectionType;

    constructor() { }

    ngOnInit() { }

    onSelect({ selected }) {
        console.log('Select Event', selected, this.selected);
    
        this.selected.splice(0, this.selected.length);
        this.selected.push(...selected);
      }
    
      onActivate(event) {
        console.log('Activate Event', event);
      }
    
      add() {
        this.selected.push(this.rows[1], this.rows[3]);
      }
    
      update() {
        this.selected = [this.rows[1], this.rows[3]];
      }
    
      remove() {
        this.selected = [];
      }
}