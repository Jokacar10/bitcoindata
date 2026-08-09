<!doctype html>
<html lang="en">

<head>
   <?php 
   $title = "Bitcoin Fuck You Status Calculator - bitcoin data.science";
   $description = "Calculate the amount of bitcoin needed to reach financial independence and 'Fuck You Status' under different regression models and inflation rates.";
   $keywords = "Bitcoin, Fuck You Status, Fuck you money, Regression, Power Law, Moving Average, 200 Weeks, Inflation, Financial Independence";
   $canonical = "https://bitcoindata.science/fuckyoumoney";
   include_once $_SERVER['DOCUMENT_ROOT'] . '/components/head.php';
   ?>
   <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Fuck You Status Calculator",
        "description": "Calculate the amount of bitcoin needed to reach 'Fuck You Status' with inflation adjustments and regression models.",
        "alternateName": [
          "bitcoindata.science",
          "Bitcoin Data Science"
        ],
        "url": "https://bitcoindata.science",
        "logo": "https://bitcoindata.science/img/logo.svg",
        "sameAs": [
          "https://bitcoindata.science"
        ]
      }
   </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="components/fuckyoumoney.js" defer></script>
</head>

<body>
   <!-- Navbar -->
   <header>
      <navbar-component></navbar-component>
   </header>
   
   <!-- Page Content -->
   <?php
   $h1 = 'Fuck You Status';
   $h2 = 'Calculate how much Bitcoin you need to reach financial independence over the next 10-20 years.
   <span class="small"><a href="https://bitcointalk.org/index.php?topic=5475347.msg63213914#msg63213914"
               class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover small fw-semibold"
               title="Reference">by JayJuanGee (JJG)</a> </span>';
   include_once $_SERVER['DOCUMENT_ROOT'] . '/components/page-header.php';
   ?>

   <p class="mb-4">
      Determine the Bitcoin stash required to fund your life, taking into account inflation, withdrawal rates, and long-term price prediction models.
   </p>

   <!-- Summary Cards for Today (rendered by JS) -->
   <p class="section-label mt-5 mb-3">Today's Overview</p>
   <div id="summary-cards" class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4 pt-lg-3 pb-lg-2"></div>

   <script>
      const SUMMARY_CARDS = [
         {
            label:    'Bitcoin Price',
            valueId:  'liveSpotPrice',
            color:    'text-body',
            footer: {
               label:   'Current 200-WMA',
               labelId: 'live200WMA',
               sub:     'Current 200-WMA',
            },
         },
         {
            label:    '10% Withdrawal Rate',
            valueId:  'todayFU10',
            color:    'text-success',
            footer: {
               label:   'Target Portfolio: $800,000',
               labelId: 'todayFU10Desc',
               sub:     'Valued at 200-WMA',
            },
         },
         {
            label:    '4% Withdrawal Rate',
            valueId:  'todayFU4',
            color:    'text-info',
            footer: {
               label:   'Target Portfolio: $2,000,000',
               labelId: 'todayFU4Desc',
               sub:     'Valued at 200-WMA',
            },
         },
         {
            label:    'Filthy-Rich Status',
            valueId:  'todayFR',
            color:    'text-purple',
            footer: {
               label:   'Fixed Target: $100,000,000',
               labelId: 'todayFRDesc',
               sub:     'Valued at 200-WMA',
            },
         },
      ];

      document.getElementById('summary-cards').innerHTML = SUMMARY_CARDS.map(card => {
         const spinner = `<span class="spinner-border spinner-border-sm" role="status"></span>`;

         const footerInner = `<div class="card-text text-muted mb-1 small" id="${card.footer.labelId}">${card.footer.label}</div>
               <span class="small text-secondary">${card.footer.sub}</span>`;

         return `
            <div class="col">
               <div class="card bg-body-tertiary shadow-sm h-100 rounded-4">
                  <div class="card-body d-flex flex-column justify-content-between">
                     <div>
                        <div class="card-text text-muted mb-2 small text-uppercase fw-bold">${card.label}</div>
                        <h5 class="card-title display-6 fw-semibold" id="${card.valueId}">${spinner}</h5>
                     </div>
                     <div class="mt-3 pt-3 border-top">${footerInner}</div>
                  </div>
               </div>
            </div>`;
      }).join('');
   </script>

   <!-- Controls and Output Area -->
   <div class="row mx-0 mt-4 mb-5 g-4">
      <!-- Input Sidebar -->
      <div class="col-lg-4 pe-lg-4 px-0">
         <div class="bg-body-tertiary rounded-4 p-4 shadow-sm">
            <h4 class="h5 mb-4 section-label">Calculation Controls</h4>
            
            <!-- Budget Input -->
            <div class="mb-4">
               <label for="annualBudget" class="form-label fw-semibold">Target Annual Budget (USD)</label>
               <div class="input-group mb-2">
                  <span class="input-group-text bg-body-secondary border-0">$</span>
                  <input type="number" class="form-control font-monospace border-0 bg-body-secondary" id="annualBudget" value="80000" min="1000" step="5000">
               </div>
               <input type="range" class="form-range" id="annualBudgetRange" min="1000" max="1001000" step="5000" value="80000">
               <div class="form-text small">Desired annual nominal purchasing power target (today's dollars).</div>
            </div>

            <!-- Inflation Input -->
            <div class="mb-4">
               <label for="inflationRate" class="form-label fw-semibold">Predicted Inflation Rate (%)</label>
               <div class="input-group mb-2">
                  <input type="number" class="form-control font-monospace border-0 bg-body-secondary" id="inflationRate" value="3.0" min="0" max="25" step="0.1">
                  <span class="input-group-text bg-body-secondary border-0">%</span>
               </div>
               <input type="range" class="form-range" id="inflationRateRange" min="0" max="15" step="0.1" value="3.0">
               <div class="form-text small">Inflation will increase your required USD target over time.</div>
            </div>

            <!-- Horizon Input -->
            <div class="mb-4">
               <label for="horizonYears" class="form-label fw-semibold">Projection Horizon</label>
               <div class="input-group mb-2">
                  <input type="number" class="form-control font-monospace border-0 bg-body-secondary" id="horizonYears" value="15" min="10" max="60" step="1">
                  <span class="input-group-text bg-body-secondary border-0">Years</span>
               </div>
               <input type="range" class="form-range" id="horizonYearsRange" min="10" max="60" step="1" value="10">
               <div class="form-text small">Extend predictions between 10 and 60 years.</div>
            </div>

            <!-- Model Selector -->
            <div class="mb-4">
               <label for="modelSelect" class="form-label fw-semibold">Prediction Model</label>
               <select class="form-select border-0 bg-body-secondary rounded-3" id="modelSelect">
                  <option value="jjg_cycle" selected>JJG Cycle Model (Self-Adjusting)</option>
                  <option value="bearish_cycle">Bearish Cycle Model (Diminishing Gains)</option>
                  <option value="stable_ratio">Stable Cycle Model</option>
               </select>
               <div class="form-text small">Choose how the future 200WMA and Spot Prices are predicted.</div>
            </div>

            <!-- Spot Price Assumption -->
            <div class="mb-3">
               <label for="spotPremiumSelect" class="form-label fw-semibold">Future Spot Price Premium</label>
               <select class="form-select border-0 bg-body-secondary rounded-3" id="spotPremiumSelect">
                  <option value="fixed" >Fixed 30% Premium above 200WMA</option>
                  <option value="cyclical" selected>Cyclical (-30% bottom / 102% top)</option>
               </select>
               <div class="form-text small">Assumed spot price relation to the predicted 200WMA.</div>
            </div>
         </div>
      </div>

      <!-- Main Content: Tabbed Charts + Table -->
      <div class="col-lg-8">
         <!-- Tabbed Navigation: Charts / Table -->
         <ul class="nav nav-tabs mb-0" id="mainViewTabs" role="tablist">
            <li class="nav-item" role="presentation">
               <button class="nav-link active text-body" id="charts-view-tab" data-bs-toggle="tab" data-bs-target="#chartsViewPane" type="button" role="tab" aria-controls="chartsViewPane" aria-selected="true">
                  CHARTS
               </button>
            </li>
            <li class="nav-item" role="presentation">
               <button class="nav-link text-body" id="table-view-tab" data-bs-toggle="tab" data-bs-target="#tableViewPane" type="button" role="tab" aria-controls="tableViewPane" aria-selected="false">
                 DATA TABLE
               </button>
            </li>
            <li class="ms-auto d-flex align-items-end">
               <button class="btn btn-sm btn-secondary mb-1" onclick="exportTableToCSV()" title="Export projections to CSV">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download me-1" viewBox="0 0 16 16">
                     <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                     <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                  </svg>CSV
               </button>
            </li>
         </ul>

         <div class="tab-content bg-body-tertiary rounded-bottom-4 shadow-sm p-4 border-top-0" id="mainViewTabsContent">
            <!-- Charts Tab Pane -->
            <div class="tab-pane fade show active" id="chartsViewPane" role="tabpanel" aria-labelledby="charts-view-tab">
               <!-- Sub-tabs for chart types -->
               <ul class="nav nav-pills mb-3 justify-content-end" id="chartTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                     <button class="btn btn-primary btn-lg d-inline-flex align-items-center justify-content-center px-4 fs-6 me-2" id="price-tab" data-bs-toggle="pill" data-bs-target="#priceChartContainer" type="button" role="tab" aria-controls="priceChartContainer" aria-selected="true">
                        Price Projection
                     </button>
                  </li>
                  <li class="nav-item" role="presentation">
                     <button class="btn btn-secondary btn-lg d-inline-flex align-items-center justify-content-center px-4 fs-6" id="coins-tab" data-bs-toggle="pill" data-bs-target="#coinsChartContainer" type="button" role="tab" aria-controls="coinsChartContainer" aria-selected="false">
                        Coins Needed
                     </button>
                  </li>
               </ul>
               
               <div class="tab-content" id="chartTabsContent">
                  <!-- Price Chart Tab -->
                  <div class="tab-pane fade show active" id="priceChartContainer" role="tabpanel" aria-labelledby="price-tab">
                     <h5 class="text-center mb-2">Bitcoin Price & 200WMA Predictions</h5>
                     <div class="row justify-content-between mb-2">
                        <div class="col-auto">
                           <span class="small border-1 px-2 border-end" onClick="priceChartPeriod(-30)"><a href="javascript:void(0);" class="pointer">1M</a></span>
                           <span class="small border-1 px-2 border-end" onClick="priceChartPeriod(-180)"><a href="javascript:void(0);" class="pointer">6M</a></span>
                           <span class="small border-1 px-2 border-end" onClick="priceChartPeriod(-365)"><a href="javascript:void(0);" class="pointer">1Y</a></span>
                           <span class="small border-1 px-2 border-end" onClick="priceChartPeriod(-1825)"><a href="javascript:void(0);" class="pointer">5Y</a></span>
                           <span class="small border-1 px-2 border-end" onClick="priceChartPeriod(-3650)"><a href="javascript:void(0);" class="pointer">10Y</a></span>
                           <span class="small border-1 px-2" onClick="priceChartPeriod()"><a href="javascript:void(0);" class="pointer link-secondary border-bottom border-3">ALL</a></span>
                        </div>
                        <div class="col-auto form-check gx-1">
                           <input class="form-check-input" type="checkbox" checked id="linLog" onchange="togglePriceLogScale();">
                           <label class="form-check-label small text-body-emphasis" for="linLog">
                              Logarithmic scale
                           </label>
                        </div>
                     </div>
                     <div id="priceChart" style="min-height: 380px;"></div>
                  </div>
                  <!-- Coins Needed Chart Tab -->
                  <div class="tab-pane fade" id="coinsChartContainer" role="tabpanel" aria-labelledby="coins-tab">
                     <h5 class="text-center mb-2">Coins Needed to Achieve FU Status</h5>
                     <div id="coinsChart" style="min-height: 380px;"></div>
                  </div>
               </div>
            </div>

            <!-- Data Table Tab Pane -->
            <div class="tab-pane fade" id="tableViewPane" role="tabpanel" aria-labelledby="table-view-tab">
               <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                  <div>
                     <h4 class="section-label mb-1">Semi-Annual Projection Data</h4>
                     <p class="text-muted small mb-0" id="tableSubtitle">Adjusted starting from today's actual price</p>
                  </div>
               </div>

               <div class="table-responsive">
                  <table class="table table-sm table-borderless table-hover align-middle small" id="projectionsTable">
                     <thead>
                        <tr class="text-nowrap text-center border-bottom">
                           <th class="fw-semibold text-body-secondary">Date</th>
                           <th class="fw-semibold text-body-secondary">Spot</th>
                           <th class="fw-semibold text-body-secondary">200 WMA</th>
                           <th class="fw-semibold text-body-secondary">% Gain / Time</th>
                           <th class="fw-semibold text-body-secondary">200 WMA Premium</th>
                           <th class="fw-semibold text-body-secondary">Coins (10% FU)</th>
                           <th class="fw-semibold text-body-secondary">Coins (4% FU)</th>
                           <th class="fw-semibold text-body-secondary">Coins (Filthy-Rich)</th>
                        </tr>
                     </thead>
                     <tbody class="font-monospace text-center" id="tableBody">
                        <tr>
                           <td colspan="8" class="text-center py-5">
                              <div class="spinner-border text-primary" role="status">
                                 <span class="visually-hidden">Loading data...</span>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <article class="bg-body-tertiary rounded-4 p-md-5 p-4 shadow-sm mt-5 mb-5">

      <p class="section-label mb-4">Understanding the Calculations</p>

      <div class="row g-4 g-lg-5 mb-4">
         <div class="col-lg-6">
            <h2 class="h5 fw-bold mb-3">What is <span class="text-secondary">"Fuck You Status"?</span></h2>
            <p class="mb-3">
               In personal finance, "Fuck You Status" is reaching a wealth status in which you are able to live comfortably at your targeted income level without being dependent on employment or external funding.
               <div class="text-muted">This level is within the election of the bitcoiner.  The amount could be replacing some portion of your current income level, or it could be replacing your actual income level or multiples of your current income level or it could be some other self-chosen income level that you would like to reach so that you don't have to work any more or rely on external funding and perhaps you would like to live a certain higher standard of living as compared with your current one.</div>
            </p>
            <p>
               By incorporating the <strong>200-week moving average (200WMA)</strong> as a valuation anchor, we insulate our assets from Bitcoin's high volatility. Because the 200WMA has historically acted as a reliable macro-cycle bottom, drawing withdrawals against the 200WMA valuation provides a highly sustainable long-term budget.
            </p>
         </div>
         
         <div class="col-lg-6">
            <h5 class="h5 fw-bold mb-3">Inflation and Purchasing Power</h5>
            <p>
               If you require a $80,000 budget in today's dollars, a constant 3.0% annual inflation rate means that in 10 years, you will need <strong>$107,513</strong> nominal dollars, and in 20 years, you will need <strong>$144,489</strong> nominal dollars to purchase the same goods.
            </p>
            <p>
               This tool adjusts your required nominal portfolios dynamically. Consequently, if Bitcoin's price appreciation outpaces inflation, the absolute number of Bitcoins you need to hold decreases dramatically over time.
            </p>
         </div>
      </div>
   </article>

   <!-- JJG Model Description -->
   <article class="bg-body-tertiary rounded-4 p-md-5 p-4 shadow-sm mb-5">

      <p class="section-label mb-4">The Prediction Models</p>

      <div class="row g-4 g-lg-5 mb-4">
         <div class="col-lg-6">
            <h2 class="h5 fw-bold mb-3">200WMA <span class="text-secondary">Semi-Annual Compounding</span></h2>
            <p>
               The 200-week moving average (200WMA) is projected forward using a <strong>semi-annual compounding</strong> model. Starting from the last known historical 200WMA value, each 6-month period applies a percentage gain:
            </p>
            <div class="bg-body-secondary rounded-3 p-3 font-monospace small mb-3">
               WMA<sub>n+1</sub> = WMA<sub>n</sub> &times; (1 + g<sub>n</sub> / 100)
            </div>
            <p>
               where <strong>g<sub>n</sub></strong> is the gain for the <em>n</em>-th semi-annual period. These gains are derived from a lookup table that reflects Bitcoin's <strong>halving-cycle dynamics</strong> — the pattern of accelerating growth in the first half of each ~4-year cycle followed by decelerating growth in the second half.
            </p>
         </div>

         <div class="col-lg-6">
            <h2 class="h5 fw-bold mb-3">Halving <span class="text-secondary">Cycle Structure</span></h2>
            <p>
               Each halving cycle spans <strong>8 semi-annual periods</strong> (~4 years). The gain table encodes this pattern: the first 4 periods carry higher growth (bullish phase), while the last 4 carry lower growth (consolidation phase). Across successive cycles, peak gains diminish — reflecting the empirical observation that each cycle's returns moderate as Bitcoin's market capitalization grows.
            </p>
            <p>
               Beyond the explicitly defined cycles (past 2039), gains are extrapolated by applying a <strong>20% decay factor per cycle</strong> to the last known cycle's values:
            </p>
            <div class="bg-body-secondary rounded-3 p-3 font-monospace small mb-3">
               g<sub>future</sub> = g<sub>base</sub> &times; 0.8<sup>(cycle − 3)</sup>
            </div>
            <p class="text-muted small">
               This ensures the model remains bounded and converges toward slower growth over very long horizons, consistent with eventual market maturation.
            </p>
         </div>
      </div>

      <div class="row g-4 g-lg-5 mb-4">
         <div class="col-lg-6">
            <h2 class="h5 fw-bold mb-3">Three <span class="text-secondary">Model Variants</span></h2>
            <p>The tool offers three prediction models, each applying a different scaling factor to the base JJG gain table:</p>
            <table class="table table-sm table-borderless small mb-3">
               <thead>
                  <tr class="border-bottom">
                     <th class="fw-semibold text-body-secondary">Model</th>
                     <th class="fw-semibold text-body-secondary">Multiplier</th>
                     <th class="fw-semibold text-body-secondary">Rationale</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td class="fw-semibold">JJG Cycle</td>
                     <td class="font-monospace">1.0&times;</td>
                     <td>Full self-adjusting gains as proposed by JayJuanGee</td>
                  </tr>
                  <tr>
                     <td class="fw-semibold">Bearish Cycle</td>
                     <td class="font-monospace">0.7&times;</td>
                     <td>30% haircut — models diminishing returns more aggressively</td>
                  </tr>
                  <tr>
                     <td class="fw-semibold">Stable Cycle</td>
                     <td class="font-monospace">0.2&times;</td>
                     <td>80% reduction — conservative floor-case scenario</td>
                  </tr>
               </tbody>
            </table>
            <p class="text-muted small mb-0">
               In all cases: <span class="font-monospace">g<sub>model</sub> = g<sub>JJG</sub> &times; multiplier</span>
            </p>
         </div>

         <div class="col-lg-6">
            <h2 class="h5 fw-bold mb-3">Spot Price <span class="text-secondary">Premium</span></h2>
            <p>
               Bitcoin's spot price typically oscillates around the 200WMA. Two assumptions are available:
            </p>
            <p>
               <strong>Fixed Premium</strong> — a constant 30% premium above the projected 200WMA:
            </p>
            <div class="bg-body-secondary rounded-3 p-3 font-monospace small mb-3">
               Spot = WMA &times; 1.30
            </div>
            <p>
               <strong>Cyclical Premium</strong> — a sine-wave oscillation synchronized to the ~4-year halving cycle, ranging from approximately &minus;30% (cycle bottom) to +102% (cycle top):
            </p>
            <div class="bg-body-secondary rounded-3 p-3 font-monospace small mb-3">
               Spot = WMA &times; [1.36 + 0.66 &times; sin(2&pi; &times; &phi;)]
            </div>
            <p class="text-muted small">
               where <span class="font-monospace">&phi; = (years mod 4) / 4</span> is the normalized cycle phase. At &phi;&nbsp;=&nbsp;0.25 (cycle peak), the multiplier reaches ≈2.02; at &phi;&nbsp;=&nbsp;0.75 (cycle bottom), it drops to ≈0.70.
            </p>
         </div>
      </div>

      <div class="row g-4 g-lg-5">
         <div class="col-lg-12">
            <h2 class="h5 fw-bold mb-3">Coins Needed <span class="text-secondary">Formula</span></h2>
            <p>
               Given a target annual budget <strong>B</strong>, a withdrawal rate <strong>r</strong>, an inflation rate <strong>i</strong>, and the projected 200WMA at year <strong>t</strong>:
            </p>
            <div class="bg-body-secondary rounded-3 p-3 font-monospace small mb-3">
               BTC needed = (B / r) &times; (1 + i)<sup>t</sup> &frasl; WMA<sub>t</sub>
            </div>
            <p>
               The numerator <span class="font-monospace">(B / r) &times; (1 + i)<sup>t</sup></span> is the inflation-adjusted portfolio target in nominal USD. Dividing by the projected 200WMA converts this to the number of Bitcoins required. As the 200WMA grows faster than inflation, the BTC needed decreases over time — this is the core insight of the model.
            </p>
            <p class="text-muted small mb-0">
               <strong>Filthy-Rich status</strong> is an exception: it uses a fixed $100,000,000 target regardless of the annual budget or inflation settings, representing a static ultra-high-net-worth benchmark.
            </p>
         </div>
      </div>

   </article>

   </main>
   <footer-component></footer-component>

   <script>
      // Listen for theme mutations to update ApexCharts colors
      var callback = function (mutationsList, observer) {
         // Look through all mutations that just occured
         for (let mutation of mutationsList) {
            // If the `data-bs-theme` attribute was modified
            if (mutation.attributeName === 'data-bs-theme') {
               recalculate();
            }
         }
      };
      var observer = new MutationObserver(callback);
      observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
   </script>
</body>

</html>
