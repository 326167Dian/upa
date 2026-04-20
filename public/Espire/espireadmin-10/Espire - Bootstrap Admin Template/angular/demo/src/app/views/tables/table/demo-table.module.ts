import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { TableSectionComponent } from './table-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { routes } from './demo-table.routes';

@NgModule({
  declarations: [
    TableSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    RouterModule.forChild(routes)
  ],
  exports: [TableSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoTableModule {
  static routes: any = routes;
}
