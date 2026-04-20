import { Component, OnInit, ChangeDetectorRef, ViewChild, HostListener } from '@angular/core';
import { ColumnMode, SelectionType } from '@swimlane/ngx-datatable';
import { DatatableComponent } from '@swimlane/ngx-datatable';
import { UserListService } from './user-list.services'
import { ScreenSizeService } from '@app/shared/services/screen-size.service';
import { delay } from 'rxjs/operators';
import { SCREEN_SIZE } from '@app/shared/types/screen-size.enum';

@Component({
    selector: 'user-list',
    templateUrl: './user-list.component.html',
    providers: [
        UserListService,
        ScreenSizeService
    ],
})
export class UserListComponent implements OnInit {

    temp = [];
    selected = [];
    users = []
    columnMode: ColumnMode = ColumnMode.force;
    SelectionType = SelectionType;
    rowHeight: 'auto' | number = 'auto'
    scrollbarH: boolean = false

    @ViewChild(DatatableComponent) table: DatatableComponent;
    constructor(private tableSvc: UserListService, private cdr: ChangeDetectorRef, private screenSizeSvc: ScreenSizeService) {  
        this.screenSizeSvc.onResize$.pipe(delay(0)).subscribe(sizes => {
            const sizeTabletAbove = sizes.includes(SCREEN_SIZE.XXL) ||  sizes.includes(SCREEN_SIZE.XL) || sizes.includes(SCREEN_SIZE.LG)
            if(sizeTabletAbove){
                this.rowHeight = 'auto'
                this.scrollbarH = false
                this.columnMode = ColumnMode.force;
            } else {
                this.rowHeight = 68
                this.scrollbarH = true
                this.columnMode = ColumnMode.force;
            }
            this.cdr.markForCheck()
        });
    }

    @HostListener('window:resize', ['$event'])windowResize(event) {
        this.getScreenWidth(event.target.innerWidth)
    }

    ngOnInit(): void {
        this.fetch()
    }

    fetch() {
        this.tableSvc.getUsers().subscribe(data => {
            this.users = data
            this.temp = [...data]
            this.cdr.markForCheck();
        });
    }

    updateFilter(event) {
        const val = event.target.value.toLowerCase();
        const temp = this.temp.filter(function (d) {
            return d.name.toLowerCase().indexOf(val) !== -1 || !val;
        });
        this.users = temp;
        this.table.offset = 0;
    }

    onSelect({ selected }) {
        this.selected.splice(0, this.selected.length);
        this.selected.push(...selected);
        console.log('Select Event', this.selected);
    }
    
    onActivate(event) {
        console.log('Activate Event', event);
    }

    getScreenWidth(size:number) {
        this.screenSizeSvc.onResize(size)
    }
}
