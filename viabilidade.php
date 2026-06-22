<?php
$page_title = "Estudo de Viabilidade Elétrica e Curva de Carga — VoltchZ Brasil";
$page_desc = "Estudo de viabilidade elétrica completo, análise de curva de carga e levantamento técnico para projetos de carregamento corporativo e industrial. Medições com equipamentos certificados pelo ICC.";
$current_page = "viabilidade";
include "includes/header.php";
?>

  <!-- HERO -->
  <header class="relative pt-32 pb-20 overflow-hidden bg-brand-bg2">
    <div class="absolute inset-0 opacity-20">
      <div class="orb w-[600px] h-[600px] -top-40 -right-40 bg-brand-green/30"></div>
    </div>
    <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
      <span class="inline-block px-4 py-1.5 rounded-full border border-brand-green/30 bg-brand-green/10 text-[11px] text-brand-green font-bold tracking-widest uppercase font-mono mb-6">
        Engenharia de Dados Elétricos
      </span>
      <h1 class="text-[clamp(36px,7vw,68px)] font-extrabold leading-tight tracking-tighter mb-8">
        Estudo de Viabilidade Elétrica<br>
        <span class="text-brand-green">e Análise de Curva de Carga</span>
      </h1>
      <p class="text-xl text-brand-muted max-w-2xl mx-auto leading-relaxed">
        Antes de qualquer projeto de carregamento corporativo ou industrial, realizamos uma análise técnica completa da infraestrutura existente — com medições certificadas e relatórios de engenharia.
      </p>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <section class="relative bg-brand-bg py-20 sm:py-28 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(34,197,94,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(34,197,94,0.03)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[600px] bg-brand-green/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="max-w-[1200px] mx-auto relative z-10">
      
      <!-- Two Column Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start observe">

        <!-- LEFT COLUMN — Visual Stack -->
        <div class="relative flex flex-col gap-5">

          <!-- Industrial Panel Photo -->
          <div class="relative rounded-[28px] overflow-hidden border border-white/10 shadow-2xl group" style="aspect-ratio:16/9">
            <img
              src="static/painel-eletrico-industrial.webp"
              alt="Painel Elétrico Industrial — VoltchZ"
              class="absolute inset-0 w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-700"
              loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-brand-bg/80 via-brand-bg/20 to-transparent"></div>
            <!-- Caption badge -->
            <div class="absolute bottom-4 left-4 right-4 flex items-center gap-3 p-3 bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl">
              <div class="w-8 h-8 rounded-lg bg-brand-green/20 border border-brand-green/30 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h4"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[13px] leading-tight">Levantamento Técnico In Loco</p>
                <p class="text-white/60 text-[11px]">Equipamentos certificados · Medições homologadas</p>
              </div>
            </div>
          </div>

          <!-- Engineer Photo -->
          <div class="relative rounded-[28px] overflow-hidden border border-white/10 shadow-2xl group" style="aspect-ratio:4/3">
            <img
              src="static/engenheiro-analise-eletrica.webp"
              alt="Engenheiro Eletricista analisando dados de curva de carga — VoltchZ"
              class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
              style="object-position: center 20%"
              loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-brand-bg/80 via-transparent to-transparent"></div>
            <!-- EPI badges -->
            <div class="absolute top-4 left-4 flex gap-2">
              <span class="px-2.5 py-1 bg-yellow-400/90 text-yellow-900 text-[10px] font-black uppercase tracking-wider rounded-full">Capacete CA</span>
              <span class="px-2.5 py-1 bg-white/90 text-slate-800 text-[10px] font-black uppercase tracking-wider rounded-full">EPI Certificado</span>
            </div>
            <div class="absolute bottom-4 left-4 right-4 flex items-center gap-3 p-3 bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl">
              <div class="w-8 h-8 rounded-lg bg-brand-green/20 border border-brand-green/30 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[13px] leading-tight">Engenheiro Responsável em Campo</p>
                <p class="text-white/60 text-[11px]">Análise presencial · Relatório técnico assinado</p>
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT COLUMN — Content & Chart -->
        <div class="flex flex-col gap-7">

          <!-- Load Curve Chart (SVG) -->
          <div class="relative p-6 sm:p-8 bg-[#0a0a0f] border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
            <!-- Chart header -->
            <div class="flex items-center justify-between mb-8">
              <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-brand-green mb-1">Monitoramento Ativo</p>
                <h4 class="text-white font-bold text-2xl">Curva de Carga</h4>
              </div>
              <div class="flex items-center gap-2 px-3 py-1.5 border border-brand-green/30 rounded-full bg-brand-green/5">
                <span class="w-2 h-2 rounded-full bg-brand-green animate-pulse"></span>
                <span class="text-[12px] font-bold text-brand-green tracking-wide">LIVE</span>
              </div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-x-8 gap-y-3 mb-6">
              <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                <div class="w-6 h-0.5 bg-brand-green rounded-full"></div>Demanda Medida
              </div>
              <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                <div class="w-6 h-0.5 border-t-2 border-dashed border-orange-500 rounded-full"></div>Potência Limite
              </div>
              <div class="flex items-center gap-2 text-[13px] text-white font-medium">
                <div class="w-6 h-0.5 bg-blue-500 rounded-full"></div>Capacidade Disponível
              </div>
            </div>

            <!-- SVG Chart -->
            <div class="w-full relative rounded-2xl bg-[#0a0a0f] border border-white/5 pb-2 pt-4 overflow-x-auto scrollbar-hide">
              <svg viewBox="0 0 800 400" preserveAspectRatio="xMidYMid meet" class="w-full h-auto min-w-[650px] sm:min-w-full min-h-[200px] sm:min-h-[280px]" role="img" aria-label="Gráfico de curva de carga elétrica">
                <defs>
                  <linearGradient id="greenFillNew" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#22c55e" stop-opacity="0.25"/>
                    <stop offset="100%" stop-color="#22c55e" stop-opacity="0"/>
                  </linearGradient>
                </defs>

                <!-- Y-axis labels -->
                <text x="35" y="15" text-anchor="end" font-size="12" fill="#a1a1aa">kVA</text>
                <text x="35" y="55" text-anchor="end" font-size="12" fill="#a1a1aa">160</text>
                <text x="35" y="130" text-anchor="end" font-size="12" fill="#a1a1aa">120</text>
                <text x="35" y="205" text-anchor="end" font-size="12" fill="#a1a1aa">80</text>
                <text x="35" y="280" text-anchor="end" font-size="12" fill="#a1a1aa">40</text>
                <text x="35" y="355" text-anchor="end" font-size="12" fill="#a1a1aa">0</text>

                <!-- Grid lines (horizontal) -->
                <g stroke="rgba(255,255,255,0.03)" stroke-width="1">
                  <line x1="50" y1="50" x2="750" y2="50"/>
                  <line x1="50" y1="125" x2="750" y2="125"/>
                  <line x1="50" y1="200" x2="750" y2="200"/>
                  <line x1="50" y1="275" x2="750" y2="275"/>
                  <line x1="50" y1="350" x2="750" y2="350"/>
                </g>

                <!-- X-axis labels -->
                <g font-size="12" fill="#a1a1aa" text-anchor="middle">
                  <text x="60" y="380">13/03</text><text x="60" y="395">00:00</text>
                  <text x="128" y="380">14/03</text><text x="128" y="395">00:00</text>
                  <text x="196" y="380">15/03</text><text x="196" y="395">00:00</text>
                  <text x="264" y="380">16/03</text><text x="264" y="395">00:00</text>
                  <text x="332" y="380">17/03</text><text x="332" y="395">00:00</text>
                  <text x="400" y="380">18/03</text><text x="400" y="395">00:00</text>
                  <text x="468" y="380">19/03</text><text x="468" y="395">00:00</text>
                  <text x="536" y="380">20/03</text><text x="536" y="395">00:00</text>
                  <text x="604" y="380">21/03</text><text x="604" y="395">00:00</text>
                  <text x="672" y="380">22/03</text><text x="672" y="395">00:00</text>
                  <text x="740" y="380">23/03</text><text x="740" y="395">00:00</text>
                </g>

                <!-- Green fill area -->
                <path d="M 60.0,320.9 L 61.4,320.2 L 62.7,314.2 L 64.1,318.5 L 65.5,298.2 L 66.8,316.0 L 68.2,297.2 L 69.5,290.0 L 70.9,268.0 L 72.3,267.5 L 73.6,250.2 L 75.0,264.8 L 76.4,279.9 L 77.7,296.7 L 79.1,299.4 L 80.4,315.4 L 81.8,304.2 L 83.2,319.4 L 84.5,315.4 L 85.9,310.9 L 87.3,299.4 L 88.6,311.0 L 90.0,315.3 L 91.3,298.6 L 92.7,307.9 L 94.1,286.3 L 95.4,298.1 L 96.8,308.9 L 98.2,302.7 L 99.5,298.7 L 100.9,310.2 L 102.2,304.5 L 103.6,317.6 L 105.0,310.1 L 106.3,310.2 L 107.7,302.9 L 109.1,309.8 L 110.4,305.5 L 111.8,304.8 L 113.1,306.2 L 114.5,300.0 L 115.9,304.4 L 117.2,307.2 L 118.6,296.7 L 120.0,307.0 L 121.3,305.9 L 122.7,313.3 L 124.0,321.0 L 125.4,307.7 L 126.8,318.5 L 128.1,306.5 L 129.5,304.7 L 130.9,309.5 L 132.2,317.4 L 133.6,310.0 L 134.9,312.4 L 136.3,311.1 L 137.7,295.5 L 139.0,284.1 L 140.4,278.3 L 141.8,272.8 L 143.1,285.5 L 144.5,285.3 L 145.9,306.0 L 147.2,307.7 L 148.6,317.0 L 149.9,307.5 L 151.3,307.7 L 152.7,303.9 L 154.0,306.1 L 155.4,295.4 L 156.8,300.5 L 158.1,301.2 L 159.5,302.4 L 160.8,290.9 L 162.2,291.5 L 163.6,283.5 L 164.9,300.4 L 166.3,300.6 L 167.7,319.3 L 169.0,312.8 L 170.4,315.4 L 171.7,316.7 L 173.1,313.1 L 174.5,308.3 L 175.8,306.0 L 177.2,295.7 L 178.6,289.5 L 179.9,277.0 L 181.3,256.8 L 182.6,251.9 L 184.0,260.8 L 185.4,283.0 L 186.7,286.0 L 188.1,306.2 L 189.5,304.5 L 190.8,308.4 L 192.2,302.7 L 193.5,317.0 L 194.9,313.0 L 196.3,307.8 L 197.6,315.6 L 199.0,315.3 L 200.4,309.3 L 201.7,301.7 L 203.1,301.2 L 204.4,307.5 L 205.8,299.1 L 207.2,306.0 L 208.5,308.4 L 209.9,308.9 L 211.3,315.4 L 212.6,303.7 L 214.0,312.7 L 215.4,306.7 L 216.7,308.7 L 218.1,317.8 L 219.4,309.5 L 220.8,303.0 L 222.2,301.0 L 223.5,311.5 L 224.9,309.1 L 226.3,284.7 L 227.6,283.8 L 229.0,271.4 L 230.3,262.8 L 231.7,281.2 L 233.1,297.2 L 234.4,304.8 L 235.8,302.7 L 237.2,306.1 L 238.5,301.8 L 239.9,307.7 L 241.2,303.2 L 242.6,308.3 L 244.0,314.1 L 245.3,303.7 L 246.7,316.6 L 248.1,305.8 L 249.4,297.5 L 250.8,303.4 L 252.1,312.2 L 253.5,307.1 L 254.9,307.7 L 256.2,312.3 L 257.6,303.6 L 259.0,314.9 L 260.3,316.7 L 261.7,312.4 L 263.0,318.1 L 264.4,315.8 L 265.8,314.4 L 267.1,304.3 L 268.5,318.1 L 269.9,310.4 L 271.2,312.5 L 272.6,288.8 L 273.9,280.8 L 275.3,282.8 L 276.7,263.8 L 278.0,268.2 L 279.4,276.3 L 280.8,287.2 L 282.1,293.9 L 283.5,295.8 L 284.8,305.9 L 286.2,307.8 L 287.6,306.9 L 288.9,311.4 L 290.3,303.6 L 291.7,298.6 L 293.0,312.7 L 294.4,296.2 L 295.8,294.6 L 297.1,289.4 L 298.5,288.9 L 299.8,299.2 L 301.2,300.5 L 302.6,313.5 L 303.9,309.2 L 305.3,299.3 L 306.7,304.8 L 308.0,310.4 L 309.4,310.4 L 310.7,301.8 L 312.1,315.6 L 313.5,309.4 L 314.8,285.6 L 316.2,285.5 L 317.6,269.3 L 318.9,271.3 L 320.3,283.1 L 321.6,285.1 L 323.0,302.0 L 324.4,302.1 L 325.7,298.1 L 327.1,315.3 L 328.5,303.5 L 329.8,320.7 L 331.2,314.1 L 332.5,312.5 L 333.9,306.3 L 335.3,318.6 L 336.6,310.2 L 338.0,311.4 L 339.4,297.8 L 340.7,318.4 L 342.1,311.4 L 343.4,296.2 L 344.8,300.3 L 346.2,287.8 L 347.5,309.8 L 348.9,308.3 L 350.3,318.0 L 351.6,303.8 L 353.0,299.7 L 354.3,314.3 L 355.7,309.7 L 357.1,314.2 L 358.4,305.5 L 359.8,305.3 L 361.2,303.0 L 362.5,285.2 L 363.9,278.2 L 365.3,259.1 L 366.6,269.7 L 368.0,268.6 L 369.3,293.7 L 370.7,306.4 L 372.1,302.9 L 373.4,299.5 L 374.8,294.4 L 376.2,291.3 L 377.5,261.0 L 378.9,249.2 L 380.2,249.0 L 381.6,262.2 L 383.0,287.3 L 384.3,286.5 L 385.7,304.0 L 387.1,304.2 L 388.4,301.6 L 389.8,307.4 L 391.1,315.6 L 392.5,308.4 L 393.9,298.8 L 395.2,308.6 L 396.6,313.8 L 398.0,304.9 L 399.3,313.2 L 400.7,309.6 L 402.0,314.7 L 403.4,313.3 L 404.8,306.6 L 406.1,305.8 L 407.5,310.0 L 408.9,317.9 L 410.2,321.0 L 411.6,309.2 L 412.9,299.7 L 414.3,299.5 L 415.7,293.4 L 417.0,294.7 L 418.4,274.5 L 419.8,271.5 L 421.1,275.6 L 422.5,289.6 L 423.8,292.7 L 425.2,299.4 L 426.6,312.1 L 427.9,310.7 L 429.3,301.7 L 430.7,320.6 L 432.0,304.3 L 433.4,314.3 L 434.7,307.0 L 436.1,319.8 L 437.5,311.2 L 438.8,305.1 L 440.2,307.0 L 441.6,312.3 L 442.9,303.3 L 444.3,301.6 L 445.7,293.2 L 447.0,283.8 L 448.4,288.9 L 449.7,281.3 L 451.1,304.9 L 452.5,296.1 L 453.8,319.7 L 455.2,303.5 L 456.6,309.6 L 457.9,321.0 L 459.3,300.8 L 460.6,299.1 L 462.0,298.4 L 463.4,298.1 L 464.7,291.1 L 466.1,282.4 L 467.5,272.2 L 468.8,264.1 L 470.2,272.7 L 471.5,294.7 L 472.9,307.6 L 474.3,309.7 L 475.6,308.3 L 477.0,296.6 L 478.4,284.8 L 479.7,263.6 L 481.1,253.7 L 482.4,254.9 L 483.8,271.9 L 485.2,273.5 L 486.5,294.1 L 487.9,312.7 L 489.3,309.9 L 490.6,305.2 L 492.0,304.7 L 493.3,317.9 L 494.7,309.0 L 496.1,298.1 L 497.4,309.4 L 498.8,314.9 L 500.2,300.6 L 501.5,299.7 L 502.9,302.7 L 504.2,294.3 L 505.6,314.7 L 507.0,305.4 L 508.3,301.2 L 509.7,307.3 L 511.1,314.7 L 512.4,320.1 L 513.8,305.1 L 515.2,302.5 L 516.5,308.8 L 517.9,300.1 L 519.2,282.6 L 520.6,263.4 L 522.0,266.2 L 523.3,256.3 L 524.7,282.2 L 526.1,295.0 L 527.4,303.4 L 528.8,306.8 L 530.1,296.1 L 531.5,307.0 L 532.9,320.8 L 534.2,319.0 L 535.6,313.2 L 537.0,320.2 L 538.3,309.3 L 539.7,315.1 L 541.0,302.7 L 542.4,303.5 L 543.8,301.3 L 545.1,309.6 L 546.5,312.3 L 547.9,304.5 L 549.2,311.9 L 550.6,315.0 L 551.9,312.4 L 553.3,314.2 L 554.7,300.4 L 556.0,302.4 L 557.4,318.6 L 558.8,320.1 L 560.1,304.2 L 561.5,312.3 L 562.8,318.8 L 564.2,298.8 L 565.6,290.2 L 566.9,283.7 L 568.3,269.8 L 569.7,256.3 L 571.0,262.4 L 572.4,284.8 L 573.7,292.2 L 575.1,291.0 L 576.5,310.7 L 577.8,303.2 L 579.2,304.1 L 580.6,304.9 L 581.9,305.4 L 583.3,312.2 L 584.6,296.7 L 586.0,298.9 L 587.4,280.4 L 588.7,259.6 L 590.1,256.2 L 591.5,266.2 L 592.8,267.9 L 594.2,282.4 L 595.6,296.8 L 596.9,313.0 L 598.3,302.5 L 599.6,305.7 L 601.0,318.1 L 602.4,310.0 L 603.7,320.6 L 605.1,318.0 L 606.5,315.2 L 607.8,307.1 L 609.2,314.5 L 610.5,300.4 L 611.9,295.2 L 613.3,315.9 L 614.6,314.0 L 616.0,295.8 L 617.4,289.8 L 618.7,290.7 L 620.1,300.1 L 621.4,302.8 L 622.8,314.8 L 624.2,314.0 L 625.5,300.2 L 626.9,309.8 L 628.3,316.1 L 629.6,299.9 L 631.0,317.8 L 632.3,309.6 L 633.7,295.9 L 635.1,287.1 L 636.4,269.5 L 637.8,252.3 L 639.2,263.6 L 640.5,275.6 L 641.9,295.2 L 643.2,297.7 L 644.6,298.5 L 646.0,308.6 L 647.3,305.2 L 648.7,309.2 L 650.1,302.8 L 651.4,307.9 L 652.8,304.4 L 654.1,299.3 L 655.5,291.9 L 656.9,280.6 L 658.2,269.0 L 659.6,265.6 L 661.0,275.5 L 662.3,286.1 L 663.7,294.0 L 665.1,311.8 L 666.4,303.1 L 667.8,305.1 L 669.1,319.4 L 670.5,321.9 L 671.9,317.9 L 673.2,304.7 L 674.6,306.7 L 676.0,318.6 L 677.3,300.7 L 678.7,316.0 L 680.0,306.1 L 681.4,298.5 L 682.8,274.4 L 684.1,263.8 L 685.5,265.5 L 686.9,276.9 L 688.2,274.3 L 689.6,292.6 L 690.9,299.0 L 692.3,306.1 L 693.7,305.4 L 695.0,317.0 L 696.4,315.7 L 697.8,308.3 L 699.1,302.0 L 700.5,306.8 L 701.8,318.0 L 703.2,311.1 L 704.6,303.5 L 705.9,285.4 L 707.3,300.3 L 708.7,304.0 L 710.0,310.1 L 711.4,296.5 L 712.7,301.3 L 714.1,316.4 L 715.5,308.8 L 716.8,310.8 L 718.2,301.0 L 719.6,311.8 L 720.9,305.6 L 722.3,306.1 L 723.6,291.3 L 725.0,278.3 L 726.4,276.4 L 727.7,283.2 L 729.1,294.8 L 730.5,291.6 L 731.8,300.1 L 733.2,311.1 L 734.5,316.8 L 735.9,311.0 L 737.3,316.0 L 738.6,321.3 L 740.0,309.2" fill="none" stroke="#22c55e" stroke-width="1.5" stroke-linejoin="round"/>

                <!-- Orange dashed limit line at ~152.4 kVA (y=64.25) -->
                <line x1="50" y1="64.25" x2="750" y2="64.25" stroke="#f97316" stroke-width="2" stroke-dasharray="8,6"/>
                <!-- Limit box on right -->
                <rect x="670" y="50" width="80" height="28" rx="6" fill="#0a0a0f" stroke="#f97316" stroke-width="1"/>
                <text x="710" y="69" text-anchor="middle" font-size="12" font-weight="bold" fill="#f97316">152,40 kVA</text>

                <!-- Peak Annotation Box -->
                <!-- Peak is at x=378.9, y=249.2 -->
                <line x1="378.9" y1="249.2" x2="378.9" y2="200" stroke="#22c55e" stroke-width="1"/>
                <rect x="303.9" y="140" width="150" height="60" rx="8" fill="#0a0a0f" stroke="#22c55e" stroke-width="1"/>
                <text x="378.9" y="165" text-anchor="middle" font-size="16" font-weight="bold" fill="#22c55e">53,74 kVA</text>
                <text x="378.9" y="185" text-anchor="middle" font-size="11" fill="#e4e4e7">Maior potência atingida</text>

                <!-- Capacity Arrow & Annotation -->
                <path d="M 580,75 L 585,85 L 575,85 Z" fill="#3b82f6"/>
                <line x1="580" y1="85" x2="580" y2="245" stroke="#3b82f6" stroke-width="2"/>
                <path d="M 580,255 L 575,245 L 585,245 Z" fill="#3b82f6"/>
                
                <rect x="595" y="130" width="110" height="80" rx="8" fill="#0a0a0f" stroke="#3b82f6" stroke-width="1"/>
                <text x="650" y="155" text-anchor="middle" font-size="16" font-weight="bold" fill="#3b82f6">98,66 kVA</text>
                <text x="650" y="175" text-anchor="middle" font-size="12" fill="#e4e4e7">Capacidade</text>
                <text x="650" y="193" text-anchor="middle" font-size="12" fill="#e4e4e7">disponível</text>

              </svg>
            </div>

            <!-- Chart footer metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-6 sm:mt-8">
              <!-- Potencia Limite -->
              <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-orange-500/30 bg-[#0a0a0f]">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <polygon points="12 7 8 13 11.5 13 11 17 16 11 12 11 12 7" fill="currentColor" stroke="none"/>
                  </svg>
                </div>
                <div>
                  <div class="text-orange-500 font-bold text-[15px] sm:text-2xl leading-none mb-1">152,40<span class="text-[9px] sm:text-base text-orange-500/80 ml-1">kVA</span></div>
                  <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Potência Limite</div>
                </div>
              </div>
              
              <!-- Maior Potencia Atingida -->
              <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-brand-green/30 bg-[#0a0a0f]">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-brand-green/10 flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                  </svg>
                </div>
                <div>
                  <div class="text-brand-green font-bold text-[15px] sm:text-2xl leading-none mb-1">53,74<span class="text-[9px] sm:text-base text-brand-green/80 ml-1">kVA</span></div>
                  <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Maior Potência Atingida</div>
                </div>
              </div>

              <!-- Capacidade Disponivel -->
              <div class="flex flex-col items-center justify-center text-center gap-2 sm:gap-3 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-blue-500/30 bg-[#0a0a0f]">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12" />
                    <path d="M12 12l4-4" />
                    <circle cx="12" cy="12" r="2" />
                  </svg>
                </div>
                <div>
                  <div class="text-blue-500 font-bold text-[15px] sm:text-2xl leading-none mb-1">98,66<span class="text-[9px] sm:text-base text-blue-500/80 ml-1">kVA</span></div>
                  <div class="text-[9px] sm:text-[13px] text-white/90 leading-tight">Capacidade Disponível</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Feature List -->
          <div class="space-y-3.5">
            <!-- Item 1 -->
            <div class="flex items-start gap-4 p-4 rounded-2xl border border-white/[0.07] bg-white/[0.03] hover:bg-white/[0.06] hover:border-brand-green/20 transition-all duration-300 group">
              <div class="w-9 h-9 rounded-xl bg-brand-green/15 border border-brand-green/25 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-green/25 transition-colors">
                <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[14px] mb-0.5">Estudo de Viabilidade Elétrica Completo</p>
                <p class="text-brand-muted text-[13px] leading-snug">Avaliação técnica da rede existente, capacidade instalada e adequação para integration de carregadores EVs.</p>
              </div>
            </div>
            <!-- Item 2 -->
            <div class="flex items-start gap-4 p-4 rounded-2xl border border-white/[0.07] bg-white/[0.03] hover:bg-white/[0.06] hover:border-brand-green/20 transition-all duration-300 group">
              <div class="w-9 h-9 rounded-xl bg-brand-green/15 border border-brand-green/25 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-green/25 transition-colors">
                <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[14px] mb-0.5">Análise Detalhada de Demanda e Consumo</p>
                <p class="text-brand-muted text-[13px] leading-snug">Identificação dos perfis de consumo por período, ponta e fora de ponta, com correlação entre setores produtivos.</p>
              </div>
            </div>
            <!-- Item 3 -->
            <div class="flex items-start gap-4 p-4 rounded-2xl border border-white/[0.07] bg-white/[0.03] hover:bg-white/[0.06] hover:border-brand-green/20 transition-all duration-300 group">
              <div class="w-9 h-9 rounded-xl bg-brand-green/15 border border-brand-green/25 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-green/25 transition-colors">
                <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[14px] mb-0.5">Levantamento Técnico para Dimensionamento Seguro</p>
                <p class="text-brand-muted text-[13px] leading-snug">Mapeamento completo da infraestrutura elétrica para garantir o correto dimensionamento de condutores, proteções e QDCs.</p>
              </div>
            </div>
            <!-- Item 4 -->
            <div class="flex items-start gap-4 p-4 rounded-2xl border border-white/[0.07] bg-white/[0.03] hover:bg-white/[0.06] hover:border-brand-green/20 transition-all duration-300 group">
              <div class="w-9 h-9 rounded-xl bg-brand-green/15 border border-brand-green/25 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-green/25 transition-colors">
                <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[14px] mb-0.5">Monitoramento Contínuo de Curva de Carga</p>
                <p class="text-brand-muted text-[13px] leading-snug">Instalação de analisadores de energia para registro de grandezas elétricas ao longo do tempo, gerando gráficos precisos.</p>
              </div>
            </div>
            <!-- Item 5 — ICC Certified -->
            <div class="flex items-start gap-4 p-4 rounded-2xl border border-brand-green/25 bg-brand-green/[0.06] hover:bg-brand-green/[0.10] transition-all duration-300 group">
              <div class="w-9 h-9 rounded-xl bg-brand-green/20 border border-brand-green/40 flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
              </div>
              <div>
                <p class="text-white font-bold text-[14px] mb-0.5">Medições com Equipamentos Certificados — ICC</p>
                <p class="text-brand-muted text-[13px] leading-snug">Todos os instrumentos utilizados possuem calibração rastreável ao INMETRO, com certificação <span class="font-bold text-brand-green">ICC (Intel Competence Center)</span>, garantindo rastreabilidade e confiabilidade metrológica.</p>
              </div>
            </div>
          </div>

          <!-- CTA -->
          <div class="flex flex-col sm:flex-row gap-3 pt-1">
            <a href="https://wa.me/5512981039845" target="_blank" rel="noopener noreferrer"
              class="inline-flex items-center justify-center gap-2.5 bg-brand-green text-brand-bg font-bold py-3.5 px-7 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-brand-green/20 text-[14px]">
              Solicitar Estudo de Viabilidade
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="contato"
              class="inline-flex items-center justify-center gap-2.5 border border-white/15 bg-white/5 text-brand-text font-bold py-3.5 px-7 rounded-2xl hover:bg-white/10 transition-all text-[14px]">
              Falar com Engenheiro
            </a>
          </div>

        </div>
        <!-- END RIGHT COLUMN -->

      </div>
    </div>
  </section>

<?php
include "includes/footer.php";
?>
