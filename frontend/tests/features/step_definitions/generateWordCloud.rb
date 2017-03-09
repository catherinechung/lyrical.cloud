Then /^I see a word cloud$/ do
    find('#vis').text.should_not eq ''
end

And /^(.*) is filled$/ do |artist|
    find('#artistLabel').text.should_not eq ''
end

And /^the (.*) and (.*) are visible$/ do |searchButton, addButton|
    find_button(searchButton)[:visible].should eq 'visible'
    find_button(addButton)[:visible].should eq 'visible'
end
