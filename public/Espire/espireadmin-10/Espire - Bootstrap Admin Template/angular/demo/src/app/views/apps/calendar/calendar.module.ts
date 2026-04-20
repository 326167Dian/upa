import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './calendar.routing.module';
import { RouterModule } from '@angular/router';
import { CalendarComponent } from './calendar.component';
import { ColumnPanelModule } from '@app/shared/components/column-panel/column-panel.module';
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { ModalModule } from 'ngx-bootstrap/modal';
import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { NgSelectModule } from '@ng-select/ng-select';
import { PopoverModule } from 'ngx-bootstrap/popover';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';

@NgModule({
    declarations: [
        CalendarComponent,
    ],
    imports: [ 
        SharedModule,
        ColumnPanelModule,
        PerfectScrollbarModule,
        NgBootstrapFormValidationModule.forRoot(),
        CalendarModule.forRoot({
            provide: DateAdapter,
            useFactory: adapterFactory,
        }),
        NgSelectModule,
        ModalModule.forRoot(),
        PopoverModule.forRoot(),
        BsDatepickerModule.forRoot(),
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class CalendarAppModule {}