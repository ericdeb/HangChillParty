
  
  

  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>examples/example.php at master from facebook's php-sdk - GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="http://github.com/fluidicon.png" title="GitHub" />

    <link href="http://assets3.github.com/stylesheets/bundle_common.css?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" media="screen" rel="stylesheet" type="text/css" />
<link href="http://assets2.github.com/stylesheets/bundle_github.css?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" media="screen" rel="stylesheet" type="text/css" />

    <script type="text/javascript" charset="utf-8">
      var GitHub = {}
      var github_user = null
      
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="http://assets1.github.com/javascripts/bundle_common.js?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" type="text/javascript"></script>
<script src="http://assets1.github.com/javascripts/bundle_github.js?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" type="text/javascript"></script>

        <script type="text/javascript" charset="utf-8">
      GitHub.spy({
        repo: "facebook/php-sdk"
      })
    </script>

    
  
    
  

  <link href="http://github.com/facebook/php-sdk/commits/master.atom" rel="alternate" title="Recent Commits to php-sdk:master" type="application/atom+xml" />

        <meta name="description" content="PHP SDK for the Facebook API" />
    <script type="text/javascript">
      GitHub.nameWithOwner = GitHub.nameWithOwner || "facebook/php-sdk";
      GitHub.currentRef = "master";
    </script>
  

            <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-3769691-2']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
      })();
    </script>

  </head>

  

  <body>
    

    
      <script type="text/javascript">
        var _kmq = _kmq || [];
        (function(){function _kms(u,d){if(navigator.appName.indexOf("Microsoft")==0 && d)document.write("<scr"+"ipt defer='defer' async='true' src='"+u+"'></scr"+"ipt>");else{var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=u;(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s);}}_kms('https://i.kissmetrics.com/i.js');_kms('http'+('https:'==document.location.protocol ? 's://s3.amazonaws.com/' : '://')+'scripts.kissmetrics.com/406e8bf3a2b8846ead55afb3cfaf6664523e3a54.1.js',1);})();
      </script>
    

    

    

    <div class="subnavd" id="main">
      <div id="header" class="pageheaded">
        <div class="site">
          <div class="logo">
            <a href="http://github.com"><img src="/images/modules/header/logov3.png" alt="github" /></a>
          </div>
          
          <div class="topsearch">
  
    <form action="/search" id="top_search_form" method="get">
      <a href="/search" class="advanced-search tooltipped downwards" title="Advanced Search">Advanced Search</a>
      <input type="search" class="search my_repos_autocompleter" name="q" results="5" placeholder="Search&hellip;" /> <input type="submit" value="Search" class="button" />
      <input type="hidden" name="type" value="Everything" />
      <input type="hidden" name="repo" value="" />
      <input type="hidden" name="langOverride" value="" />
      <input type="hidden" name="start_value" value="1" />
    </form>
  
  
    <ul class="nav logged_out">
      
        <li><a href="http://github.com">Home</a></li>
        <li class="pricing"><a href="/plans">Pricing and Signup</a></li>
        <li><a href="http://github.com/explore">Explore GitHub</a></li>
        
        <li><a href="/blog">Blog</a></li>
      
      <li><a href="https://github.com/login">Login</a></li>
    </ul>
  
</div>

        </div>
      </div>

      
      
        
    <div class="site">
      <div class="pagehead repohead vis-public   ">
        <h1>
          <a href="/facebook">facebook</a> / <strong><a href="http://github.com/facebook/php-sdk">php-sdk</a></strong>
          
          
        </h1>

        
    <ul class="actions">
      

      
        <li class="for-owner" style="display:none"><a href="https://github.com/facebook/php-sdk/edit" class="minibutton btn-admin "><span><span class="icon"></span>Admin</span></a></li>
        <li>
          <a href="/facebook/php-sdk/toggle_watch" class="minibutton btn-watch " id="watch_button" style="display:none"><span><span class="icon"></span>Watch</span></a>
          <a href="/facebook/php-sdk/toggle_watch" class="minibutton btn-watch " id="unwatch_button" style="display:none"><span><span class="icon"></span>Unwatch</span></a>
        </li>
        
          
            <li class="for-notforked" style="display:none"><a href="/facebook/php-sdk/fork" class="minibutton btn-fork " id="fork_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', 'e039136539d2520a7a4eccd5738ffdd0e53d8c84'); f.appendChild(s);f.submit();return false;"><span><span class="icon"></span>Fork</span></a></li>
            <li class="for-hasfork" style="display:none"><a href="#" class="minibutton btn-fork " id="your_fork_button"><span><span class="icon"></span>Your Fork</span></a></li>
          

          
          <li id="pull_request_item" class='ospr' style="display:none"><a href="/facebook/php-sdk/pull_request/" class="minibutton btn-pull-request "><span><span class="icon"></span>Pull Request</span></a></li>
          

          <li><a href="#" class="minibutton btn-download " id="download_button"><span><span class="icon"></span>Download Source</span></a></li>
        
      
      
      <li class="repostats">
        <ul class="repo-stats">
          <li class="watchers"><a href="/facebook/php-sdk/watchers" title="Watchers" class="tooltipped downwards">323</a></li>
          <li class="forks"><a href="/facebook/php-sdk/network" title="Forks" class="tooltipped downwards">42</a></li>
        </ul>
      </li>
    </ul>


        
  <ul class="tabs">
    <li><a href="http://github.com/facebook/php-sdk/tree/master" class="selected" highlight="repo_source">Source</a></li>
    <li><a href="http://github.com/facebook/php-sdk/commits/master" highlight="repo_commits">Commits</a></li>

    
    <li><a href="/facebook/php-sdk/network" highlight="repo_network">Network (42)</a></li>

    

    
      
      <li><a href="/facebook/php-sdk/issues" highlight="issues">Issues (20)</a></li>
    

    
      
      <li><a href="/facebook/php-sdk/downloads">Downloads (5)</a></li>
    

    
      
      <li><a href="http://wiki.github.com/facebook/php-sdk/">Wiki (6)</a></li>
    

    <li><a href="/facebook/php-sdk/graphs" highlight="repo_graphs">Graphs</a></li>

    <li class="contextswitch nochoices">
      <span class="toggle leftwards" >
        <em>Branch:</em>
        <code>master</code>
      </span>
    </li>
  </ul>

  <div style="display:none" id="pl-description"><p><em class="placeholder">click here to add a description</em></p></div>
  <div style="display:none" id="pl-homepage"><p><em class="placeholder">click here to add a homepage</em></p></div>

  <div class="subnav-bar">
  
  <ul>
    <li>
      <a href="#" class="dropdown">Switch Branches (1)</a>
      <ul>
        
          
            <li><strong>master &#x2713;</strong></li>
            
      </ul>
    </li>
    <li>
      <a href="#" class="dropdown ">Switch Tags (5)</a>
              <ul>
                      
              <li><a href="/facebook/php-sdk/blob/v2.0.4/examples/example.php">v2.0.4</a></li>
            
                      
              <li><a href="/facebook/php-sdk/blob/v2.0.3/examples/example.php">v2.0.3</a></li>
            
                      
              <li><a href="/facebook/php-sdk/blob/v2.0.2/examples/example.php">v2.0.2</a></li>
            
                      
              <li><a href="/facebook/php-sdk/blob/v2.0.1/examples/example.php">v2.0.1</a></li>
            
                      
              <li><a href="/facebook/php-sdk/blob/v2.0.0/examples/example.php">v2.0.0</a></li>
            
                  </ul>
      
    </li>
    <li>
    
    <a href="/facebook/php-sdk/branches" class="manage">Branch List</a>
    
    </li>
  </ul>
</div>

  
  
  
  
  


        
    <div id="repo_details" class="metabox clearfix">
      <div id="repo_details_loader" class="metabox-loader" style="display:none">Sending Request&hellip;</div>

      

      <div id="repository_description" rel="repository_description_edit">
        
          <p>PHP SDK for the Facebook API
            <span id="read_more" style="display:none">&mdash; <a href="#readme">Read more</a></span>
          </p>
        
      </div>
      <div id="repository_description_edit" style="display:none;" class="inline-edit">
        <form action="/facebook/php-sdk/edit/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="e039136539d2520a7a4eccd5738ffdd0e53d8c84" /></div>
          <input type="hidden" name="field" value="repository_description">
          <input type="text" class="textfield" name="value" value="PHP SDK for the Facebook API">
          <div class="form-actions">
            <button class="minibutton"><span>Save</span></button> &nbsp; <a href="#" class="cancel">Cancel</a>
          </div>
        </form>
      </div>

      
      <div class="repository-homepage" id="repository_homepage" rel="repository_homepage_edit">
        <p><a href="http://" rel="nofollow"></a></p>
      </div>
      <div id="repository_homepage_edit" style="display:none;" class="inline-edit">
        <form action="/facebook/php-sdk/edit/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="e039136539d2520a7a4eccd5738ffdd0e53d8c84" /></div>
          <input type="hidden" name="field" value="repository_homepage">
          <input type="text" class="textfield" name="value" value="">
          <div class="form-actions">
            <button class="minibutton"><span>Save</span></button> &nbsp; <a href="#" class="cancel">Cancel</a>
          </div>
        </form>
      </div>

      <div class="rule "></div>

      <div id="url_box" class="url-box">
        <ul class="clone-urls">
          
            
            <li id="http_clone_url"><a href="http://github.com/facebook/php-sdk.git" data-permissions="Read-Only">HTTP</a></li>
            <li id="public_clone_url"><a href="git://github.com/facebook/php-sdk.git" data-permissions="Read-Only">Git Read-Only</a></li>
          
        </ul>
        <input type="text" spellcheck="false" id="url_field" class="url-field" />
              <span style="display:none" id="url_box_clippy"></span>
      <span id="clippy_tooltip_url_box_clippy" class="clippy-tooltip tooltipped" title="copy to clipboard">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="14"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="http://assets0.github.com/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=url_box_clippy&amp;copied=&amp;copyto=">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="http://assets0.github.com/flash/clippy.swf?v5"
             width="14"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=url_box_clippy&amp;copied=&amp;copyto="
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      </span>

        <p id="url_description">This URL has <strong>Read+Write</strong> access</p>
      </div>
    </div>


        

      </div><!-- /.pagehead -->

      









<script type="text/javascript">
  GitHub.currentCommitRef = "master"
  GitHub.currentRepoOwner = "facebook"
  GitHub.currentRepo = "php-sdk"
  GitHub.downloadRepo = '/facebook/php-sdk/archives/master'

  

  
</script>










  <div id="commit">
    <div class="group">
        
  <div class="envelope commit">
    <div class="human">
      
        <div class="message"><pre><a href="/facebook/php-sdk/commit/9a71839dcdfb58b355bd4307d2bc7d526c51579e">directly set the $params as CURLOPT_POSTFIELDS</a> </pre></div>
      

      <div class="actor">
        <div class="gravatar">
          
          <img src="http://www.gravatar.com/avatar/162ba763482bf53ed1d9a4589fad393f?s=140&d=http%3A%2F%2Fgithub.com%2Fimages%2Fgravatars%2Fgravatar-140.png" alt="" width="30" height="30"  />
        </div>
        <div class="name"><a href="/nshah">nshah</a> <span>(author)</span></div>
        <div class="date">
          <abbr class="relatize" title="2010-05-19 12:55:38">Wed May 19 12:55:38 -0700 2010</abbr>
        </div>
      </div>

      

    </div>
    <div class="machine">
      <span>c</span>ommit&nbsp;&nbsp;<a href="/facebook/php-sdk/commit/9a71839dcdfb58b355bd4307d2bc7d526c51579e" hotkey="c">9a71839dcdfb58b355bd</a><br />
      <span>t</span>ree&nbsp;&nbsp;&nbsp;&nbsp;<a href="/facebook/php-sdk/tree/9a71839dcdfb58b355bd4307d2bc7d526c51579e" hotkey="t">eaa18516cb7d18ed737b</a><br />
      
        <span>p</span>arent&nbsp;
        
        <a href="/facebook/php-sdk/tree/c9db0b411842076b32ecbc49327f9f745ff3e567" hotkey="p">c9db0b411842076b32ec</a>
      

    </div>
  </div>

    </div>
  </div>



  
    <div id="path">
      <b><a href="/facebook/php-sdk/tree/master">php-sdk</a></b> / <a href="/facebook/php-sdk/tree/master/examples">examples</a> / example.php       <span style="display:none" id="clippy_3045">examples/example.php</span>
      
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="110"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="http://assets0.github.com/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=clippy_3045&amp;copied=copied!&amp;copyto=copy to clipboard">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="http://assets0.github.com/flash/clippy.swf?v5"
             width="110"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=clippy_3045&amp;copied=copied!&amp;copyto=copy to clipboard"
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      

    </div>

    <div id="files">
      <div class="file">
        <div class="meta">
          <div class="info">
            <span class="icon"><img alt="Txt" height="16" src="http://assets1.github.com/images/icons/txt.png?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" width="16" /></span>
            <span class="mode" title="File Mode">100644</span>
            
              <span>128 lines (111 sloc)</span>
            
            <span>3.632 kb</span>
          </div>
          <ul class="actions">
            
              <li><a id="file-edit-link" href="#" rel="/facebook/php-sdk/file-edit/__ref__/examples/example.php">edit</a></li>
            
            <li><a href="/facebook/php-sdk/raw/master/examples/example.php" id="raw-url">raw</a></li>
            
              <li><a href="/facebook/php-sdk/blame/master/examples/example.php">blame</a></li>
            
            <li><a href="/facebook/php-sdk/commits/master/examples/example.php">history</a></li>
          </ul>
        </div>
        
  <div class="data syntax type-php">
    
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <pre class="line_numbers"><span id="LID1" rel="#L1">1</span>
<span id="LID2" rel="#L2">2</span>
<span id="LID3" rel="#L3">3</span>
<span id="LID4" rel="#L4">4</span>
<span id="LID5" rel="#L5">5</span>
<span id="LID6" rel="#L6">6</span>
<span id="LID7" rel="#L7">7</span>
<span id="LID8" rel="#L8">8</span>
<span id="LID9" rel="#L9">9</span>
<span id="LID10" rel="#L10">10</span>
<span id="LID11" rel="#L11">11</span>
<span id="LID12" rel="#L12">12</span>
<span id="LID13" rel="#L13">13</span>
<span id="LID14" rel="#L14">14</span>
<span id="LID15" rel="#L15">15</span>
<span id="LID16" rel="#L16">16</span>
<span id="LID17" rel="#L17">17</span>
<span id="LID18" rel="#L18">18</span>
<span id="LID19" rel="#L19">19</span>
<span id="LID20" rel="#L20">20</span>
<span id="LID21" rel="#L21">21</span>
<span id="LID22" rel="#L22">22</span>
<span id="LID23" rel="#L23">23</span>
<span id="LID24" rel="#L24">24</span>
<span id="LID25" rel="#L25">25</span>
<span id="LID26" rel="#L26">26</span>
<span id="LID27" rel="#L27">27</span>
<span id="LID28" rel="#L28">28</span>
<span id="LID29" rel="#L29">29</span>
<span id="LID30" rel="#L30">30</span>
<span id="LID31" rel="#L31">31</span>
<span id="LID32" rel="#L32">32</span>
<span id="LID33" rel="#L33">33</span>
<span id="LID34" rel="#L34">34</span>
<span id="LID35" rel="#L35">35</span>
<span id="LID36" rel="#L36">36</span>
<span id="LID37" rel="#L37">37</span>
<span id="LID38" rel="#L38">38</span>
<span id="LID39" rel="#L39">39</span>
<span id="LID40" rel="#L40">40</span>
<span id="LID41" rel="#L41">41</span>
<span id="LID42" rel="#L42">42</span>
<span id="LID43" rel="#L43">43</span>
<span id="LID44" rel="#L44">44</span>
<span id="LID45" rel="#L45">45</span>
<span id="LID46" rel="#L46">46</span>
<span id="LID47" rel="#L47">47</span>
<span id="LID48" rel="#L48">48</span>
<span id="LID49" rel="#L49">49</span>
<span id="LID50" rel="#L50">50</span>
<span id="LID51" rel="#L51">51</span>
<span id="LID52" rel="#L52">52</span>
<span id="LID53" rel="#L53">53</span>
<span id="LID54" rel="#L54">54</span>
<span id="LID55" rel="#L55">55</span>
<span id="LID56" rel="#L56">56</span>
<span id="LID57" rel="#L57">57</span>
<span id="LID58" rel="#L58">58</span>
<span id="LID59" rel="#L59">59</span>
<span id="LID60" rel="#L60">60</span>
<span id="LID61" rel="#L61">61</span>
<span id="LID62" rel="#L62">62</span>
<span id="LID63" rel="#L63">63</span>
<span id="LID64" rel="#L64">64</span>
<span id="LID65" rel="#L65">65</span>
<span id="LID66" rel="#L66">66</span>
<span id="LID67" rel="#L67">67</span>
<span id="LID68" rel="#L68">68</span>
<span id="LID69" rel="#L69">69</span>
<span id="LID70" rel="#L70">70</span>
<span id="LID71" rel="#L71">71</span>
<span id="LID72" rel="#L72">72</span>
<span id="LID73" rel="#L73">73</span>
<span id="LID74" rel="#L74">74</span>
<span id="LID75" rel="#L75">75</span>
<span id="LID76" rel="#L76">76</span>
<span id="LID77" rel="#L77">77</span>
<span id="LID78" rel="#L78">78</span>
<span id="LID79" rel="#L79">79</span>
<span id="LID80" rel="#L80">80</span>
<span id="LID81" rel="#L81">81</span>
<span id="LID82" rel="#L82">82</span>
<span id="LID83" rel="#L83">83</span>
<span id="LID84" rel="#L84">84</span>
<span id="LID85" rel="#L85">85</span>
<span id="LID86" rel="#L86">86</span>
<span id="LID87" rel="#L87">87</span>
<span id="LID88" rel="#L88">88</span>
<span id="LID89" rel="#L89">89</span>
<span id="LID90" rel="#L90">90</span>
<span id="LID91" rel="#L91">91</span>
<span id="LID92" rel="#L92">92</span>
<span id="LID93" rel="#L93">93</span>
<span id="LID94" rel="#L94">94</span>
<span id="LID95" rel="#L95">95</span>
<span id="LID96" rel="#L96">96</span>
<span id="LID97" rel="#L97">97</span>
<span id="LID98" rel="#L98">98</span>
<span id="LID99" rel="#L99">99</span>
<span id="LID100" rel="#L100">100</span>
<span id="LID101" rel="#L101">101</span>
<span id="LID102" rel="#L102">102</span>
<span id="LID103" rel="#L103">103</span>
<span id="LID104" rel="#L104">104</span>
<span id="LID105" rel="#L105">105</span>
<span id="LID106" rel="#L106">106</span>
<span id="LID107" rel="#L107">107</span>
<span id="LID108" rel="#L108">108</span>
<span id="LID109" rel="#L109">109</span>
<span id="LID110" rel="#L110">110</span>
<span id="LID111" rel="#L111">111</span>
<span id="LID112" rel="#L112">112</span>
<span id="LID113" rel="#L113">113</span>
<span id="LID114" rel="#L114">114</span>
<span id="LID115" rel="#L115">115</span>
<span id="LID116" rel="#L116">116</span>
<span id="LID117" rel="#L117">117</span>
<span id="LID118" rel="#L118">118</span>
<span id="LID119" rel="#L119">119</span>
<span id="LID120" rel="#L120">120</span>
<span id="LID121" rel="#L121">121</span>
<span id="LID122" rel="#L122">122</span>
<span id="LID123" rel="#L123">123</span>
<span id="LID124" rel="#L124">124</span>
<span id="LID125" rel="#L125">125</span>
<span id="LID126" rel="#L126">126</span>
<span id="LID127" rel="#L127">127</span>
<span id="LID128" rel="#L128">128</span>
</pre>
          </td>
          <td width="100%">
            
              <div class="highlight"><pre><div class='line' id='LC1'><span class="cp">&lt;?php</span></div><div class='line' id='LC2'><br/></div><div class='line' id='LC3'><span class="k">require</span> <span class="s1">&#39;../src/facebook.php&#39;</span><span class="p">;</span></div><div class='line' id='LC4'><br/></div><div class='line' id='LC5'><span class="c1">// Create our Application instance.</span></div><div class='line' id='LC6'><span class="nv">$facebook</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Facebook</span><span class="p">(</span><span class="k">array</span><span class="p">(</span></div><div class='line' id='LC7'>&nbsp;&nbsp;<span class="s1">&#39;appId&#39;</span>  <span class="o">=&gt;</span> <span class="s1">&#39;254752073152&#39;</span><span class="p">,</span></div><div class='line' id='LC8'>&nbsp;&nbsp;<span class="s1">&#39;secret&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;904270b68a2cc3d54485323652da4d14&#39;</span><span class="p">,</span></div><div class='line' id='LC9'>&nbsp;&nbsp;<span class="s1">&#39;cookie&#39;</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span></div><div class='line' id='LC10'><span class="p">));</span></div><div class='line' id='LC11'><br/></div><div class='line' id='LC12'><span class="c1">// We may or may not have this data based on a $_GET or $_COOKIE based session.</span></div><div class='line' id='LC13'><span class="c1">//</span></div><div class='line' id='LC14'><span class="c1">// If we get a session here, it means we found a correctly signed session using</span></div><div class='line' id='LC15'><span class="c1">// the Application Secret only Facebook and the Application know. We dont know</span></div><div class='line' id='LC16'><span class="c1">// if it is still valid until we make an API call using the session. A session</span></div><div class='line' id='LC17'><span class="c1">// can become invalid if it has already expired (should not be getting the</span></div><div class='line' id='LC18'><span class="c1">// session back in this case) or if the user logged out of Facebook.</span></div><div class='line' id='LC19'><span class="nv">$session</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">getSession</span><span class="p">();</span></div><div class='line' id='LC20'><br/></div><div class='line' id='LC21'><span class="nv">$me</span> <span class="o">=</span> <span class="k">null</span><span class="p">;</span></div><div class='line' id='LC22'><span class="c1">// Session based API call.</span></div><div class='line' id='LC23'><span class="k">if</span> <span class="p">(</span><span class="nv">$session</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC24'>&nbsp;&nbsp;<span class="k">try</span> <span class="p">{</span></div><div class='line' id='LC25'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nv">$uid</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">getUser</span><span class="p">();</span></div><div class='line' id='LC26'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nv">$me</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">api</span><span class="p">(</span><span class="s1">&#39;/me&#39;</span><span class="p">);</span></div><div class='line' id='LC27'>&nbsp;&nbsp;<span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">FacebookApiException</span> <span class="nv">$e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC28'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nb">error_log</span><span class="p">(</span><span class="nv">$e</span><span class="p">);</span></div><div class='line' id='LC29'>&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC30'><span class="p">}</span></div><div class='line' id='LC31'><br/></div><div class='line' id='LC32'><span class="c1">// login or logout url will be needed depending on current user state.</span></div><div class='line' id='LC33'><span class="k">if</span> <span class="p">(</span><span class="nv">$me</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC34'>&nbsp;&nbsp;<span class="nv">$logoutUrl</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">getLogoutUrl</span><span class="p">();</span></div><div class='line' id='LC35'><span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC36'>&nbsp;&nbsp;<span class="nv">$loginUrl</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">getLoginUrl</span><span class="p">();</span></div><div class='line' id='LC37'><span class="p">}</span></div><div class='line' id='LC38'><br/></div><div class='line' id='LC39'><span class="c1">// This call will always work since we are fetching public data.</span></div><div class='line' id='LC40'><span class="nv">$naitik</span> <span class="o">=</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">api</span><span class="p">(</span><span class="s1">&#39;/naitik&#39;</span><span class="p">);</span></div><div class='line' id='LC41'><br/></div><div class='line' id='LC42'><span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC43'><span class="x">&lt;!doctype html&gt;</span></div><div class='line' id='LC44'><span class="x">&lt;html xmlns:fb=&quot;http://www.facebook.com/2008/fbml&quot;&gt;</span></div><div class='line' id='LC45'><span class="x">  &lt;head&gt;</span></div><div class='line' id='LC46'><span class="x">    &lt;title&gt;php-sdk&lt;/title&gt;</span></div><div class='line' id='LC47'><span class="x">    &lt;style&gt;</span></div><div class='line' id='LC48'><span class="x">      body {</span></div><div class='line' id='LC49'><span class="x">        font-family: &#39;Lucida Grande&#39;, Verdana, Arial, sans-serif;</span></div><div class='line' id='LC50'><span class="x">      }</span></div><div class='line' id='LC51'><span class="x">      h1 a {</span></div><div class='line' id='LC52'><span class="x">        text-decoration: none;</span></div><div class='line' id='LC53'><span class="x">        color: #3b5998;</span></div><div class='line' id='LC54'><span class="x">      }</span></div><div class='line' id='LC55'><span class="x">      h1 a:hover {</span></div><div class='line' id='LC56'><span class="x">        text-decoration: underline;</span></div><div class='line' id='LC57'><span class="x">      }</span></div><div class='line' id='LC58'><span class="x">    &lt;/style&gt;</span></div><div class='line' id='LC59'><span class="x">  &lt;/head&gt;</span></div><div class='line' id='LC60'><span class="x">  &lt;body&gt;</span></div><div class='line' id='LC61'><span class="x">    &lt;!--</span></div><div class='line' id='LC62'><span class="x">      We use the JS SDK to provide a richer user experience. For more info,</span></div><div class='line' id='LC63'><span class="x">      look here: http://github.com/facebook/connect-js</span></div><div class='line' id='LC64'><span class="x">    --&gt;</span></div><div class='line' id='LC65'><span class="x">    &lt;div id=&quot;fb-root&quot;&gt;&lt;/div&gt;</span></div><div class='line' id='LC66'><span class="x">    &lt;script&gt;</span></div><div class='line' id='LC67'><span class="x">      window.fbAsyncInit = function() {</span></div><div class='line' id='LC68'><span class="x">        FB.init({</span></div><div class='line' id='LC69'><span class="x">          appId   : &#39;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$facebook</span><span class="o">-&gt;</span><span class="na">getAppId</span><span class="p">();</span> <span class="cp">?&gt;</span><span class="x">&#39;,</span></div><div class='line' id='LC70'><span class="x">          session : </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nx">json_encode</span><span class="p">(</span><span class="nv">$session</span><span class="p">);</span> <span class="cp">?&gt;</span><span class="x">, // don&#39;t refetch the session when PHP already has it</span></div><div class='line' id='LC71'><span class="x">          status  : true, // check login status</span></div><div class='line' id='LC72'><span class="x">          cookie  : true, // enable cookies to allow the server to access the session</span></div><div class='line' id='LC73'><span class="x">          xfbml   : true // parse XFBML</span></div><div class='line' id='LC74'><span class="x">        });</span></div><div class='line' id='LC75'><br/></div><div class='line' id='LC76'><span class="x">        // whenever the user logs in, we refresh the page</span></div><div class='line' id='LC77'><span class="x">        FB.Event.subscribe(&#39;auth.login&#39;, function() {</span></div><div class='line' id='LC78'><span class="x">          window.location.reload();</span></div><div class='line' id='LC79'><span class="x">        });</span></div><div class='line' id='LC80'><span class="x">      };</span></div><div class='line' id='LC81'><br/></div><div class='line' id='LC82'><span class="x">      (function() {</span></div><div class='line' id='LC83'><span class="x">        var e = document.createElement(&#39;script&#39;);</span></div><div class='line' id='LC84'><span class="x">        e.src = document.location.protocol + &#39;//connect.facebook.net/en_US/all.js&#39;;</span></div><div class='line' id='LC85'><span class="x">        e.async = true;</span></div><div class='line' id='LC86'><span class="x">        document.getElementById(&#39;fb-root&#39;).appendChild(e);</span></div><div class='line' id='LC87'><span class="x">      }());</span></div><div class='line' id='LC88'><span class="x">    &lt;/script&gt;</span></div><div class='line' id='LC89'><br/></div><div class='line' id='LC90'><br/></div><div class='line' id='LC91'><span class="x">    &lt;h1&gt;&lt;a href=&quot;example.php&quot;&gt;php-sdk&lt;/a&gt;&lt;/h1&gt;</span></div><div class='line' id='LC92'><br/></div><div class='line' id='LC93'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$me</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC94'><span class="x">    &lt;a href=&quot;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$logoutUrl</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x">&quot;&gt;</span></div><div class='line' id='LC95'><span class="x">      &lt;img src=&quot;http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif&quot;&gt;</span></div><div class='line' id='LC96'><span class="x">    &lt;/a&gt;</span></div><div class='line' id='LC97'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">else</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC98'><span class="x">    &lt;div&gt;</span></div><div class='line' id='LC99'><span class="x">      Using JavaScript &amp;amp; XFBML: &lt;fb:login-button&gt;&lt;/fb:login-button&gt;</span></div><div class='line' id='LC100'><span class="x">    &lt;/div&gt;</span></div><div class='line' id='LC101'><span class="x">    &lt;div&gt;</span></div><div class='line' id='LC102'><span class="x">      Without using JavaScript &amp;amp; XFBML:</span></div><div class='line' id='LC103'><span class="x">      &lt;a href=&quot;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$loginUrl</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x">&quot;&gt;</span></div><div class='line' id='LC104'><span class="x">        &lt;img src=&quot;http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif&quot;&gt;</span></div><div class='line' id='LC105'><span class="x">      &lt;/a&gt;</span></div><div class='line' id='LC106'><span class="x">    &lt;/div&gt;</span></div><div class='line' id='LC107'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">endif</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC108'><br/></div><div class='line' id='LC109'><span class="x">    &lt;h3&gt;Session&lt;/h3&gt;</span></div><div class='line' id='LC110'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$me</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC111'><span class="x">    &lt;pre&gt;</span><span class="cp">&lt;?php</span> <span class="nb">print_r</span><span class="p">(</span><span class="nv">$session</span><span class="p">);</span> <span class="cp">?&gt;</span><span class="x">&lt;/pre&gt;</span></div><div class='line' id='LC112'><br/></div><div class='line' id='LC113'><span class="x">    &lt;h3&gt;You&lt;/h3&gt;</span></div><div class='line' id='LC114'><span class="x">    &lt;img src=&quot;https://graph.facebook.com/</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$uid</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x">/picture&quot;&gt;</span></div><div class='line' id='LC115'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$me</span><span class="p">[</span><span class="s1">&#39;name&#39;</span><span class="p">];</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC116'><br/></div><div class='line' id='LC117'><span class="x">    &lt;h3&gt;Your User Object&lt;/h3&gt;</span></div><div class='line' id='LC118'><span class="x">    &lt;pre&gt;</span><span class="cp">&lt;?php</span> <span class="nb">print_r</span><span class="p">(</span><span class="nv">$me</span><span class="p">);</span> <span class="cp">?&gt;</span><span class="x">&lt;/pre&gt;</span></div><div class='line' id='LC119'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">else</span><span class="o">:</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC120'><span class="x">    &lt;strong&gt;&lt;em&gt;You are not Connected.&lt;/em&gt;&lt;/strong&gt;</span></div><div class='line' id='LC121'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">endif</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC122'><br/></div><div class='line' id='LC123'><span class="x">    &lt;h3&gt;Naitik&lt;/h3&gt;</span></div><div class='line' id='LC124'><span class="x">    &lt;img src=&quot;https://graph.facebook.com/naitik/picture&quot;&gt;</span></div><div class='line' id='LC125'><span class="x">    </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$naitik</span><span class="p">[</span><span class="s1">&#39;name&#39;</span><span class="p">];</span> <span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC126'><span class="x">  &lt;/body&gt;</span></div><div class='line' id='LC127'><span class="x">&lt;/html&gt;</span></div><div class='line' id='LC128'><br/></div></pre></div>
            
          </td>
        </tr>
      </table>
    
  </div>


      </div>
    </div>

  


    </div>
  
      

      <div class="push"></div>
    </div>

    <div id="footer">
      <div class="site">
        <div class="info">
          <div class="links">
            <a href="http://github.com/blog"><b>Blog</b></a> |
            <a href="http://support.github.com">Support</a> |
            <a href="http://github.com/training">Training</a> |
            <a href="http://github.com/contact">Contact</a> |
            <a href="http://develop.github.com">API</a> |
            <a href="http://status.github.com">Status</a> |
            <a href="http://twitter.com/github">Twitter</a> |
            <a href="http://help.github.com">Help</a> |
            <a href="http://github.com/security">Security</a>
          </div>
          <div class="company">
            &copy;
            2010
            <span id="_rrt" title="0.05046s from fe4.rs.github.com">GitHub</span> Inc.
            All rights reserved. |
            <a href="/site/terms">Terms of Service</a> |
            <a href="/site/privacy">Privacy Policy</a>
          </div>
        </div>
        <div class="sponsor">
          <div>
            Powered by the <a href="http://www.rackspace.com ">Dedicated
            Servers</a> and<br/> <a href="http://www.rackspacecloud.com">Cloud
            Computing</a> of Rackspace Hosting<span>&reg;</span>
          </div>
          <a href="http://www.rackspace.com">
            <img alt="Dedicated Server" src="http://assets1.github.com/images/modules/footer/rackspace_logo.png?53081acd2dd130cebd1da08f5aa8f7897bb3ae9e" />
          </a>
        </div>
      </div>
    </div>

    <script>window._auth_token = "e039136539d2520a7a4eccd5738ffdd0e53d8c84"</script>
    

    <script type="text/javascript">
      _kmq.push(['trackClick', 'entice_banner_link', 'Entice banner clicked']);
      
    </script>
    
  </body>
</html>

