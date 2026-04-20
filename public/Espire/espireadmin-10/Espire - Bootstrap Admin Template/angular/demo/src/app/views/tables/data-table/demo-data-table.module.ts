import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { DataTableSectionComponent } from './data-table-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { CheckboxModule } from '@app/shared/components/checkbox/checkbox.module';
import { routes } from './demo-data-table.routes';

@NgModule({
  declarations: [
    DataTableSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    NgxDatatableModule,
    CheckboxModule,
    RouterModule.forChild(routes)
  ],
  exports: [DataTableSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoDataTableModule {
  static routes: any = routes;
}
