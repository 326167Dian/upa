

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';
import { DemoAmMapBasicComponent } from './demos/basic/basic';
import { DemoAmMapMultiSeriesComponent } from './demos/multi-series/multi-series';
import { DemoAmMapRotatingGlobeComponent } from './demos/rotating-globe/rotating-globe';
import { DemoAmMapPacificCenteredComponent } from './demos/pacific-centered/pacific-centered';
import { DemoAmMapAlongLineComponent } from './demos/along-line/along-line';
import { DemoAmMapCurvedLineComponent } from './demos/curved-line/curved-line';
import { DemoAmMapUsHeatComponent } from './demos/us-heat/us-heat';
import { DemoAmMapGroupedCountriesComponent } from './demos/grouped-countries/grouped-countries';
import { DemoAmMapWeatherComponent } from './demos/weather/weather'; 

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: ``,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoAmMapBasicComponent
      },
      {
        title: 'Multi Series',
        anchor: 'multi-series',
        description: ``,
        component: require('!!raw-loader!./demos/multi-series/multi-series'),
        html: require('!!raw-loader!./demos/multi-series/multi-series.html'),
        outlet: DemoAmMapMultiSeriesComponent
      },
      {
        title: 'Rotating Globe',
        anchor: 'rotating-globe',
        description: ``,
        component: require('!!raw-loader!./demos/rotating-globe/rotating-globe'),
        html: require('!!raw-loader!./demos/rotating-globe/rotating-globe.html'),
        outlet: DemoAmMapRotatingGlobeComponent
      },
      {
        title: 'Pacific Centered',
        anchor: 'pacific-centered',
        description: ``,
        component: require('!!raw-loader!./demos/pacific-centered/pacific-centered'),
        html: require('!!raw-loader!./demos/pacific-centered/pacific-centered.html'),
        outlet: DemoAmMapPacificCenteredComponent
      },
      {
        title: 'Animated Along Line',
        anchor: 'along-line',
        description: ``,
        component: require('!!raw-loader!./demos/along-line/along-line'),
        html: require('!!raw-loader!./demos/along-line/along-line.html'),
        outlet: DemoAmMapAlongLineComponent
      },
      {
        title: 'Map with curved lines',
        anchor: 'curved-line',
        description: ``,
        component: require('!!raw-loader!./demos/curved-line/curved-line'),
        html: require('!!raw-loader!./demos/curved-line/curved-line.html'),
        outlet: DemoAmMapCurvedLineComponent
      },
      {
        title: 'US heat (choropleth) map',
        anchor: 'us-heat',
        description: ``,
        component: require('!!raw-loader!./demos/us-heat/us-heat'),
        html: require('!!raw-loader!./demos/us-heat/us-heat.html'),
        outlet: DemoAmMapUsHeatComponent
      },
      {
        title: 'Grouped countries map',
        anchor: 'grouped-countries',
        description: ``,
        component: require('!!raw-loader!./demos/grouped-countries/grouped-countries'),
        html: require('!!raw-loader!./demos/grouped-countries/grouped-countries.html'),
        outlet: DemoAmMapGroupedCountriesComponent
      },
      {
        title: 'Weather map',
        anchor: 'weather',
        description: ``,
        component: require('!!raw-loader!./demos/weather/weather'),
        html: require('!!raw-loader!./demos/weather/weather.html'),
        outlet: DemoAmMapWeatherComponent
      },
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'AmmapComponent',
        anchor: 'AmmapComponent',
        outlet: NgApiDocComponent
      }
    ]
  }
];
