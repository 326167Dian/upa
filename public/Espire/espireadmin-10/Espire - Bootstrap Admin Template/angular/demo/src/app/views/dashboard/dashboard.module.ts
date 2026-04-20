import { NgModule } from '@angular/core';
import { CommonModule } from "@angular/common";
import { DashboardRoutingModule } from './dashboard-routing.module'
import { ProgressbarModule } from 'ngx-bootstrap/progressbar';
import { NgApexchartsModule } from "ng-apexcharts";
import { AvatarModule } from '@app/shared/components/avatar/avatar.module';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';

import { DashboardComponent } from './dashboard.component';
import { MonthlyRevenueComponent } from './components/monthly-revenue/monthly-revenue.component';
import { QuaterRevenueComponent } from './components/quater-revenue/quater-revenue.component';
import { RegionDataComponent } from './components/region-data/region-data.component';
import { OverviewComponent } from './components/overview/overview-component';
import { RecentTransactionComponent } from './components/recent-transaction/recent-transaction.component';
import { RecentRatingComponent } from './components/recent-rating/recent-rating.component';
import { DeviceStatisticComponent } from './components/device-statistic/device-statistic.component';
import { CountriesComponent } from './components/countries/countries.component';

import { DashboardService } from './dashboard.service';

@NgModule({
    imports: [
        CommonModule,
        DashboardRoutingModule,
        NgApexchartsModule,
        ProgressbarModule,
        AvatarModule,
        PerfectScrollbarModule
    ],
    exports: [],
    declarations: [
        DashboardComponent,
        MonthlyRevenueComponent,
        QuaterRevenueComponent,
        RegionDataComponent,
        OverviewComponent,
        RecentTransactionComponent,
        RecentRatingComponent,
        DeviceStatisticComponent,
        CountriesComponent
    ],
    providers: [
        DashboardService
    ],
})
export class DashboardModule { }
