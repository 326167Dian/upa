import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { GoogleMapSectionComponent } from './google-map-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { routes } from './demo-google-map.routes';
import { GoogleMapsModule } from '@angular/google-maps';

@NgModule({
  declarations: [
    GoogleMapSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    RouterModule.forChild(routes),
    GoogleMapsModule
  ],
  exports: [GoogleMapSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoGoogleMapModule {
  static routes: any = routes;
}
