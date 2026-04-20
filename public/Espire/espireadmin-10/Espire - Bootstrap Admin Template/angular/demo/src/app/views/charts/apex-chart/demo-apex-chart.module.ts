import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { ApexChartSectionComponent } from './apex-chart-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { routes } from './demo-apex-chart.routes';
import { NgApexchartsModule } from "ng-apexcharts";

@NgModule({
  declarations: [
    ApexChartSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    NgApexchartsModule,
    RouterModule.forChild(routes)
  ],
  exports: [ApexChartSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoApexChartModule {
  static routes: any = routes;
}
