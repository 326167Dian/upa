import { Component, OnInit, Input, Output, EventEmitter, ChangeDetectorRef } from '@angular/core';
import { ColumnMode, SelectionType } from '@swimlane/ngx-datatable';
import { MailService } from '../mail.service'
import { categoryList, category } from '../mail.component'

@Component({
    selector: 'mail-list',
    templateUrl: './mail-list.component.html',
    host: {
        '[class.mail-list]': 'true'
    }
})
export class MailListComponent implements OnInit {

    @Input() data = []
    @Input() loading = false
    @Input() showMailContent = false
    @Input() selectedMail: string
    @Output() rowClick: EventEmitter<string> = new EventEmitter<string>();
    @Output() onMobilePanelOpen = new EventEmitter<string>();

    selected: string[] = [];
    displayNoMailMessage = false
 
    ColumnMode = ColumnMode;
    SelectionType = SelectionType;

    catogories: category[] = categoryList
 
    constructor(private mailSvc: MailService, private cdr: ChangeDetectorRef) { }
 
    ngOnInit(): void { }

    onMark(id: number, value: number) {
        let newValue: number
        if(value === 0) {
            newValue = 1
        }
        if(value === 1) {
            newValue = 0
        }
        const newData = this.data.map(elm => {
            if(elm.id === id) {
                elm.marked = newValue
            }
            return elm
        })
        this.data = newData
        this.mailSvc.updateMark(id, newValue).subscribe()
    }

    onRowClick(id: string, event) {
        this.rowClick.emit(id)
        event.stopPropagation();
    }

    formatBody(body:string) {
        return body.replace(/<(?:.|\n)*?>/gm, ' ');
    }

    onCheckboxChangeFn(id: string, event) {
        event.stopPropagation();
        if(event.target.checked && !this.selected.includes(id)) {
            this.selected.push(id)
        } else {
            this.selected = this.selected.filter(e => e !== id);
        }
    }

    deleteSelectedMail() {
        if(this.selected.length > 0) {
            this.mailSvc.deleteMail(this.selected).subscribe(res => {
                this.data = res
                this.selected = []
                if(this.data.length === 0) {
                    this.displayNoMailMessage = true
                }
                this.cdr.detectChanges()
            });
        }
    }

    selectAll(event) {
        const val = event.target.checked
        this.data = this.data.map(elm => {
            if(val) {
                this.selected.push(elm.id)
            } else {
                this.selected = []
            }
            elm.checked = val
            return elm
        })
    }

    onMobilePanelToggleClick() {
        this.onMobilePanelOpen.emit()
    }
}
