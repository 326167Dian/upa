import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { DataService } from './data.service';

@Component({
    selector: 'demo-select-multi',
    templateUrl: 'multi.html'
})

export class DemoSelectMultiComponent implements OnInit {
    
    people$: Observable<any[]>;
    selectedPeople = [{ name: 'Karyn Wright' }];

    constructor(private dataService: DataService) {
    }

    ngOnInit() {
        this.people$ = this.dataService.getPeople();
    }

    clearModel() {
        this.selectedPeople = [];
    }

    changeModel() {
        this.selectedPeople = [{ name: 'New person' }];
    }
}