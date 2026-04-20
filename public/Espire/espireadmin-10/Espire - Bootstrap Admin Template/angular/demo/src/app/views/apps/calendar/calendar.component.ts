import { Component, ViewChildren, ViewChild, TemplateRef, OnInit, AfterViewInit, QueryList, ChangeDetectorRef } from '@angular/core';
import { BsModalService, BsModalRef } from 'ngx-bootstrap/modal';
import { FormBuilder, FormGroup, Validators} from "@angular/forms";
import {
    startOfDay,
    endOfDay,
    subDays,
    addDays,
    endOfMonth,
    isSameDay,
    isSameMonth,
    addHours,
} from 'date-fns';
import { Subject } from 'rxjs';
import {
    CalendarEvent,
    CalendarEventTimesChangedEvent,
    CalendarView,
} from 'angular-calendar';
import { PopoverDirective } from 'ngx-bootstrap/popover';
import { GenerateUid } from '@app/shared/utils/GenerateUid';
import { combineLatest } from 'rxjs';

interface CalendarAppEvent extends CalendarEvent {
    description?: string
}

const colors: any = {
    red: {
        primary: '#ef2733',
        secondary: '#fde9eb',
    },
    blue: {
        primary: '#3d5ef8',
        secondary: '#eef1fe',
    },
    yellow: {
        primary: '#ff8911',
        secondary: '#fff4ea',
    },
};

const colorsSelection: any[] = [
    {
        color: colors.red
    },
    {
        color: colors.blue
    },
    {
        color: colors.yellow
    }
]
  

@Component({
    selector: 'calendar',
    templateUrl: './calendar.component.html'
})
export class CalendarComponent implements OnInit, AfterViewInit {

    @ViewChildren(PopoverDirective) popovers: QueryList<PopoverDirective>;
    view: CalendarView = CalendarView.Month;
    CalendarView = CalendarView;
    viewDate: Date = new Date();
    modalRef: BsModalRef;
    modalMode: 'add' | 'edit' = 'add'
    formGroup: FormGroup;
    selectedEventId: string | number
    modalData: {
        action: string;
        event: CalendarAppEvent;
    };
    colorsSelection: string[] = []
    refresh: Subject<any> = new Subject();
    events: CalendarAppEvent[] = [
        {
            id: 1,
            start: subDays(startOfDay(new Date()), 1),
            end: addDays(new Date(), 1),
            title: 'A 3 day event',
            color: colors.red,
            allDay: true,
            description: 'Some contents',
            resizable: {
                beforeStart: true,
                afterEnd: true,
            },
            draggable: true,
        },
        {
            id: 2,
            start: startOfDay(new Date()),
            end: null,
            title: 'An event with no end date',
            color: colors.yellow,
        },
        {
            id: 3,
            start: subDays(endOfMonth(new Date()), 3),
            end: addDays(endOfMonth(new Date()), 3),
            title: 'A long event that spans 2 months',
            description: 'Some contents',
            color: colors.blue,
            allDay: true,
        },
        {
            id: 4,
            start: addHours(startOfDay(new Date()), 2),
            end: addHours(new Date(), 2),
            title: 'A draggable and resizable event',
            description: 'Some contents',
            color: colors.yellow,
            resizable: {
                beforeStart: true,
                afterEnd: true,
            },
            draggable: true,
        },
    ];

    constructor(
        private modalService: BsModalService, 
        private formBuilder: FormBuilder,
        private cdr: ChangeDetectorRef
    ) { }

    ngOnInit(): void {
        for (const key in colors) {
            if (Object.prototype.hasOwnProperty.call(colors, key)) {
                this.colorsSelection.push(key)
            }
        }
        this.formGroup = this.formBuilder.group({
            id: [GenerateUid(10)],
            title: ['', Validators.required],
            start: [startOfDay(new Date()), Validators.required],
            end: [endOfDay(new Date()), Validators.required],
            color: [this.colorsSelection[0], Validators.required],
            description: [''],
        });
    }

    ngAfterViewInit() {
        this.popovers.forEach((popover: PopoverDirective) => {
            popover.onShown.subscribe(() => {
                this.popovers
                .filter(p => p !== popover)
                .forEach(p => p.hide());
            });
        });
    }

    dayClicked({ date, events }: { date: Date; events: CalendarAppEvent[] }): void {
        if (isSameMonth(date, this.viewDate)) {
            this.viewDate = date;
        }
    }
    
    eventTimesChanged({ event, newStart, newEnd }: CalendarEventTimesChangedEvent): void {
        this.events = this.events.map((iEvent) => {
            if (iEvent === event) {
                return {
                    ...event,
                    start: newStart,
                    end: newEnd,
                };
            }
            return iEvent;
        });
        this.handleEvent('Dropped or resized', event);
    }
    
    handleEvent(action: string, event: CalendarAppEvent): void {
        this.modalData = { event, action };
    }

    getColorDetail(val: string) {
        return colors[val]
    }

    eventAddOn (color :string) {
        return {
            color: this.getColorDetail(color),
            draggable: true,
            resizable: {
                beforeStart: true,
                afterEnd: true,
            },
        }
    }
    
    addEvent(): void {
        let data = this.formGroup.value
        const dataAddon = this.eventAddOn(data.color)
        data = {...data, ...dataAddon}
        this.events = [
            ...this.events,
            data
        ];
        this.modalRef.hide()
        this.resetForm()
    }
    
    editEvent() {
        let data = this.formGroup.value
        const dataAddon = this.eventAddOn(data.color)
        data = {...data, ...dataAddon}
        this.events = this.events.map(event => {
            if(event.id === data.id) {
                event = data
            }
            return event
        })
        this.modalRef.hide()
        this.resetForm()
    }

    deleteEvent(id: string | number) {
        this.events = this.events.filter((event) => event.id !== id);
    }

    resetForm() {
        this.modalMode = 'add'
        this.formGroup.reset();
        this.formGroup.setValue({
            id: GenerateUid(10),
            title: '',
            start: startOfDay(new Date()),
            end: endOfDay(new Date()),
            color: this.colorsSelection[0],
            description: ''
        })
    }
    
    setView(view: CalendarView) {
        this.view = view;
    }

    openEditEventModal(template: TemplateRef<any>, id: string | number) {
        this.modalMode = 'edit'
        this.modalRef = this.modalService.show(template);
        let data = this.events.filter(elm => elm.id === id)[0]
        let color : string
        for (const key in colors) {
            if (Object.prototype.hasOwnProperty.call(colors, key)) {
                const element = colors[key];
                if(element.primary === data.color.primary) {
                    color = key
                }
            }
        }
        this.formGroup.setValue({
            id: data.id,
            title: data.title,
            start: data.start,
            end: data.end,
            color: color,
            description: data.description
        })
        this.onModalClose()
    }

    openAddEventModal(template: TemplateRef<any>) {
        this.modalMode = 'add'
        this.modalRef = this.modalService.show(template);
        this.onModalClose()
    }

    onModalClose() {
        const _combine = combineLatest(
            this.modalRef.onHide,
            this.modalRef.onHidden
        ).subscribe(() => this.cdr.markForCheck());
        this.modalRef.onHide.subscribe((reason: string | any) => {
            this.resetForm()
        })
    }
}
